<?php

namespace RegexParser\Lexer;

use RegexParser\Stream;

class TokenStream extends Stream
{
    protected $lexer;

    public function __construct(Lexer $lexer)
    {
        $this->lexer = $lexer;
        parent::__construct(array());
    }

    public function next()
    {
        $token = $this->lexer->nextToken();

        if ($token === false) {
            return false;
        }

        $this->input[] = $token;

        return parent::next();
    }

    public function readAt($index)
    {
        if ($index > 0 && $this->lexer->getStream()->cursor()-$this->cursor < $index) {
            $i = 0;
            while (($token = $this->lexer->nextToken()) && $i<$index) {
                $this->input[] = $token;
                $i++;
            }
        }

        return parent::readAt($index);
    }

    public function hasNext()
    {
        if ($this->cursor < $this->lexer->getStream()->cursor()) {
            return true;
        }

        return $this->lexer->getStream()->hasNext();
    }
}
