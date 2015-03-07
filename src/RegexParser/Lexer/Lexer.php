<?php

namespace RegexParser\Lexer;

use RegexParser\Lexer\Exception\LexerException;

/**
 * ...
 */
class Lexer
{
    /**
     * [$stream description]
     *
     * @var StringStream
     */
    protected $stream;

    /**
     * [$currentChar description]
     *
     * @var string
     */
    protected $currentChar;

    /**
     * [$lexemeMap description]
     *
     * @var null|array
     */
    protected static $lexemeMap = null;

    /**
     * [__construct description]
     *
     * @param StringStream $stream [description]
     */
    public function __construct(StringStream $stream)
    {
        $this->stream = $stream;

        if (self::$lexemeMap === null) {
            self::$lexemeMap = array_flip(json_decode(file_get_contents(__DIR__.'/Resource/config/tokens.json'), true));
        }
    }

    /**
     * [create description]
     *
     * @param string $input [description]
     *
     * @return Lexer
     */
    public static function create($input)
    {
        return new self(new StringStream($input));
    }

    /**
     * [getStream description]
     *
     * @return StringStream
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * [nextToken description]
     *
     * @throws LexerException If [this condition is met]
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
     * [readUnicode description]
     *
     * @throws LexerException If [this condition is met]
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
     * [isWhitespace description]
     *
     * @param string $char [description]
     *
     * @return boolean
     */
    protected function isWhitespace($char)
    {
        // IE treats non-breaking space as \u00A0
        return ($char === " " || $char === "\r" || $char === "\t" ||
                $char === "\n" || $char === "\v" || $char === "\u00A0");
    }

    /**
     * [isInteger description]
     *
     * @param string $char [description]
     *
     * @return boolean
     */
    protected function isInteger($char)
    {
        return $char >= '0' && $char <= '9';
    }

    /**
     * [isAlpha description]
     *
     * @param string $char [description]
     *
     * @return boolean
     */
    protected function isAlpha($char)
    {
        return ($char >= 'a' && $char <= 'z') ||
               ($char >= 'A' && $char <= 'Z');
    }

    /**
     * [isNewLine description]
     *
     * @param string $char [description]
     *
     * @return boolean
     */
    protected function isNewLine($char)
    {
        return $char === "\r" || $char === "\n";
    }
}
