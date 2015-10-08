<?php

namespace RegexParser\Lexer;

class EscapeToken extends Token
{
    /**
     * @var bool
     */
    protected $isExclusionSequence;

    /**
     * @param string $name
     * @param mixed  $value
     * @param bool   $isExclusionSequence
     */
    public function __construct($name, $value, $isExclusionSequence = false)
    {
        parent::__construct($name, $value);
        $this->isExclusionSequence = $isExclusionSequence;
    }

    /**
     * @param bool $isExclusionSequence
     */
    public function setIsExclusionSequence($isExclusionSequence)
    {
        $this->isExclusionSequence = $isExclusionSequence;
    }

    /**
     * @return bool
     */
    public function isExclusionSequence()
    {
        return $this->isExclusionSequence;
    }
}
