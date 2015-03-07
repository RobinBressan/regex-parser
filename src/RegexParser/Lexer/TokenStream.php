<?php

namespace RegexParser\Lexer;

use RegexParser\Stream;

/**
 * ...
 */
class TokenStream extends Stream
{
    /**
     * [$lexer description]
     *
     * @var Lexer
     */
    protected $lexer;

    /**
     * [__construct description]
     *
     * @param Lexer $lexer [description]
     */
    public function __construct(Lexer $lexer)
    {
        $this->lexer = $lexer;
        parent::__construct(array());
    }

    /**
     * [next description]
     *
     * @return mixed
     */
    public function next()
    {
        $token = $this->lexer->nextToken();

        if ($token === false) {
            return false;
        }

        $this->input[] = $token;

        return parent::next();
    }

    /**
     * [readAt description]
     *
     * @param integer $index [description]
     *
     * @return mixed
     */
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

    /**
     * [hasNext description]
     *
     * @return boolean [description]
     */
    public function hasNext()
    {
        if ($this->cursor < $this->lexer->getStream()->cursor()) {
            return true;
        }

        return $this->lexer->getStream()->hasNext();
    }
}
