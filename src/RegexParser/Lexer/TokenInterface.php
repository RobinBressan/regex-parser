<?php

namespace RegexParser\Lexer;

/**
 * ...
 */
interface TokenInterface
{
    /**
     * [is description]
     *
     * @param string $tokenName [description]
     *
     * @return boolean
     */
    public function is($tokenName);

    /**
     * [getName description]
     *
     * @return string
     */
    public function getName();

    /**
     * [getValue description]
     *
     * @return mixed
     */
    public function getValue();
}
