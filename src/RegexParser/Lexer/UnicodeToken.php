<?php

namespace RegexParser\Lexer;

class UnicodeToken extends Token
{
    protected $isExclusionSequence;

    public function __construct($name, $value, $isExclusionSequence = false)
    {
        parent::__construct($name, $value);
        $this->isExclusionSequence = $isExclusionSequence;
    }

    public function setIsExclusionSequence($isExclusionSequence)
    {
        $this->isExclusionSequence = $isExclusionSequence;
    }

    public function isExclusionSequence()
    {
        return $this->isExclusionSequence;
    }
}
