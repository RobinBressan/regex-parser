<?php

namespace RegexParser\Lexer;

use RegexParser\Lexer\Exception\LexerException;
use Symfony\Component\Yaml\Parser;

class Lexer
{
    protected $stream;

    protected $currentChar;

    protected static $lexemeMap = null;

    public function __construct(StringStream $stream)
    {
        $this->stream = $stream;

        if (self::$lexemeMap === null) {
            self::$lexemeMap = array_flip(json_decode(file_get_contents(__DIR__.'/Resource/config/tokens.json'), true));
        }
    }

    public static function create($input)
    {
        return new self(new StringStream($input));
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function nextToken()
    {
        if (($char = $this->stream->next()) === false) {
            return false;
        }

        if (isset(self::$lexemeMap[$char]) && substr(self::$lexemeMap[$char], 0, strlen('T_UNICODE')) !== 'T_UNICODE') {
            return new Token(self::$lexemeMap[$char], $char);
        }

        if ($this->isInteger($char)) {
            return new Token('T_INTEGER', (int)$char);
        }

        if ($this->isAlpha($char) || $this->isWhitespace($char)) {
            return new Token('T_CHAR', $char);
        }

        if ($char === '\\') {
            $readAt1 = $this->stream->readAt(1);
            if ($readAt1 === '\\') {
                $this->stream->next();
                return new Token('T_BACKSLASH', '\\');
            } else if (($readAt1 === 'p' || $readAt1 === 'P')) {
                return $this->readUnicode();
            } else {
                return new Token('T_CHAR', $this->stream->next());
            }
        }

        throw new LexerException(sprintf('Unknown token %s at %s', $char, $this->stream->cursor()));
    }

    private function readUnicode()
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
            return new UnicodeToken(self::$lexemeMap[$token], $token, $isExclusionSequence);
        }

        throw new LexerException(sprintf('Unknown unicode token %s at %s', $token, $this->stream->cursor()));
    }

    private function isWhitespace($char)
    {
        // IE treats non-breaking space as \u00A0
        return ($char === " " || $char === "\r" || $char === "\t" ||
                $char === "\n" || $char === "\v" || $char === "\u00A0");
    }

    private function isInteger($char)
    {
        return $char >= '0' && $char <= '9';
    }

    private function isAlpha($char)
    {
        return ($char >= 'a' && $char <= 'z') ||
               ($char >= 'A' && $char <= 'Z');
    }

    private function isNewLine($char)
    {
        return $char === "\r" || $char === "\n";
    }
}
