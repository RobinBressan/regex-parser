<?php

namespace RegexParser\Lexer;

class EscapeToken extends Token
{
    /**
     * @var boolean
     */
    protected $isExclusionSequence;

    /**
     * @param string  $name
     * @param mixed   $value
     * @param boolean $isExclusionSequence
     */
    public function __construct($name, $value, $isExclusionSequence = false)
    {
        parent::__construct($name, $value);
        $this->isExclusionSequence = $isExclusionSequence;
    }

    /**
     * @param boolean $isExclusionSequence
     *
     * @return void
     */
    public function setIsExclusionSequence($isExclusionSequence)
    {
        $this->isExclusionSequence = $isExclusionSequence;
    }

    /**
     * @return boolean
     */
    public function isExclusionSequence()
    {
        return $this->isExclusionSequence;
    }
}
