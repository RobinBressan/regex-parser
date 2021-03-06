<?php

namespace RegexParser\Lexer;

use RegexParser\Lexer\Exception\LexerException;

class Lexer
{
    /**
     * @var StringStream
     */
    protected $stream;

    /**
     * @var string
     */
    protected $currentChar;

    /**
     * @var null|array
     */
    protected static $lexemeMap = null;

    /**
     * @param StringStream $stream
     */
    public function __construct(StringStream $stream)
    {
        $this->stream = $stream;

        if (self::$lexemeMap === null) {
            self::$lexemeMap = array_flip(json_decode(file_get_contents(__DIR__.'/Resource/config/tokens.json'), true));
        }
    }

    /**
     * @param string $input
     *
     * @return Lexer
     */
    public static function create($input)
    {
        return new self(new StringStream($input));
    }

    /**
     * @return StringStream
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * @throws LexerException
     *
     * @return Token|EscapeToken|void
     */
    public function nextToken()
    {
        if (($char = $this->stream->next()) === false) {
            return false;
        }

        if (isset(self::$lexemeMap[$char]) &&
            mb_substr(self::$lexemeMap[$char], 0, strlen('T_UNICODE')) !== 'T_UNICODE' &&
            mb_substr(self::$lexemeMap[$char], 0, strlen('T_ANY')) !== 'T_ANY') {
            return new Token(self::$lexemeMap[$char], $char);
        }

        if ($this->isInteger($char)) {
            return new Token('T_INTEGER', (int) $char);
        }

        if ($this->isAlpha($char) || $this->isWhitespace($char)) {
            return new Token('T_CHAR', $char);
        }

        if ($char === '\\') {
            $readAt1 = $this->stream->readAt(1);
            if ($readAt1 === '\\') {
                $this->stream->next();

                return new Token('T_BACKSLASH', '\\');
            }

            if ($readAt1 === 'p' || $readAt1 === 'P') {
                return $this->readUnicode();
            }

            if ($readAt1 === 'X') {
                return new EscapeToken('T_UNICODE_X', 'X');
            }

            if (isset(self::$lexemeMap[$readAt1]) && mb_substr(self::$lexemeMap[$readAt1], 0, strlen('T_ANY')) === 'T_ANY') {
                return new EscapeToken(self::$lexemeMap[$readAt1], $readAt1);
            }

            if (isset(self::$lexemeMap[mb_strtolower($readAt1)]) && mb_substr(self::$lexemeMap[mb_strtolower($readAt1)], 0, strlen('T_ANY')) === 'T_ANY') {
                return new EscapeToken(self::$lexemeMap[mb_strtolower($readAt1)], $readAt1, true);
            }

            return new Token('T_CHAR', $this->stream->next());
        }

        throw new LexerException(sprintf('Unknown token %s at %s', $char, $this->stream->cursor()));
    }

    /**
     * @throws LexerException
     *
     * @return EscapeToken|void
     */
    protected function readUnicode()
    {
        $isExclusionSequence = $this->stream->next() === 'P';
        $isWithBrace = $this->stream->next() === '{';

        if (!$isWithBrace) {
            $token = $this->stream->current();
        } else {
            $token = '';
            if ($this->stream->readAt(1) === '^') {
                $isExclusionSequence = true;
                $this->stream->next();
            }

            do {
                $char = $this->stream->next();

                if ($char !== '}') {
                    $token .= $char;
                }
            } while ($char && $char !== '}');

            if ($char !== '}') {
                throw new LexerException(sprintf('Unknown token %s at %s', $char, $this->stream->cursor()));
            }
        }

        if (isset(self::$lexemeMap[$token])) {
            return new EscapeToken(self::$lexemeMap[$token], $token, $isExclusionSequence);
        }

        throw new LexerException(sprintf('Unknown unicode token %s at %s', $token, $this->stream->cursor()));
    }

    /**
     * @param string $char
     *
     * @return bool
     */
    protected function isWhitespace($char)
    {
        // IE treats non-breaking space as \u00A0
        return ($char === ' ' || $char === "\r" || $char === "\t" ||
                $char === "\n" || $char === "\v" || $char === "\u00A0");
    }

    /**
     * @param string $char
     *
     * @return bool
     */
    protected function isInteger($char)
    {
        return $char >= '0' && $char <= '9';
    }

    /**
     * @param string $char
     *
     * @return bool
     */
    protected function isAlpha($char)
    {
        return ($char >= 'a' && $char <= 'z') ||
               ($char >= 'A' && $char <= 'Z');
    }

    /**
     * @param string $char
     *
     * @return bool
     */
    protected function isNewLine($char)
    {
        return $char === "\r" || $char === "\n";
    }
}
