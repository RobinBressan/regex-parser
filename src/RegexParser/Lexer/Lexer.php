<?php

namespace RegexParser\Lexer;

class Lexer
{
    protected $stream;

    protected $currentChar;

    protected $lexemeMap = array (
        '^' =>  'T_HAT',
        '$' =>  'T_DOLLAR',
        '.' =>  'T_PERIOD',
        '[' =>  'T_LEFT_BRACKET',
        ']' =>  'T_RIGHT_BRACKET',
        '|' =>  'T_PIPE',
        '(' =>  'T_LEFT_PARENTHESIS',
        ')' =>  'T_RIGHT_PARENTHESIS',
        '{' =>  'T_LEFT_BRACE',
        '}' =>  'T_RIGHT_BRACE',
        '?' =>  'T_QUESTION',
        '*' =>  'T_MULTIPLY',
        '+' =>  'T_PLUS',
        '-' =>  'T_MINUS',
        ':' =>  'T_COLON',
        ',' =>  'T_COMMA',
        '!' =>  'T_EXCLAMATION',
        '=' =>  'T_EQUALS',
        '>' =>  'T_GREATER',
        '<' =>  'T_LOWER',
        '#' =>  'T_POUND',
        '\''=>  'T_QUOTE',
        '"' =>  'T_DOUBLE_QUOTE',
        '/' =>  'T_SLASH',
        '_' =>  'T_UNDERSCORE',
        '@' =>  'T_AT'
    );

    public function __construct(StringStream $stream)
    {
        $this->stream = $stream;
    }

    public static function create($input)
    {
        return new self(new StringStream($input));
    }

    public function nextToken()
    {
        if (($char = $this->stream->next()) === false) {
            return false;
        }

        if (isset($this->lexemeMap[$char])) {
            return new Token($this->lexemeMap[$char], $char);
        }

        if ($this->isInteger($char)) {
            return new Token('T_INTEGER', (int)$char);
        }

        if ($this->isAlpha($char) || $this->isWhitespace($char)) {
            return new Token('T_CHAR', $char);
        }

        if ($char === '\\') {
            if ($this->stream->readAt(1) === '\\') {
                $this->stream->next();
                return new Token('T_CHAR', '\\');
            } else {
                return new Token('T_CHAR', $this->stream->next());
            }
        }

        throw new \Exception('Lexer error for ' . $char . ' at ' . $this->stream->cursor());
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
