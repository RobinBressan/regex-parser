<?php

namespace RegexParser\Lexer;

/**
 * ...
 */
class EscapeToken extends Token
{
    /**
     * [$isExclusionSequence description]
     *
     * @var boolean
     */
    protected $isExclusionSequence;

    /**
     * [__construct description]
     *
     * @param string  $name                [description]
     * @param mixed   $value               [description]
     * @param boolean $isExclusionSequence [description]
     */
    public function __construct($name, $value, $isExclusionSequence = false)
    {
        parent::__construct($name, $value);
        $this->isExclusionSequence = $isExclusionSequence;
    }

    /**
     * [setIsExclusionSequence description]
     *
     * @param boolean $isExclusionSequence [description]
     *
     * @return void
     */
    public function setIsExclusionSequence($isExclusionSequence)
    {
        $this->isExclusionSequence = $isExclusionSequence;
    }

    /**
     * [isExclusionSequence description]
     *
     * @return boolean [description]
     */
    public function isExclusionSequence()
    {
        return $this->isExclusionSequence;
    }
}
