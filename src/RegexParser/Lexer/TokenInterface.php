<?php

namespace RegexParser\Lexer;

interface TokenInterface
{
    /**
     * @param string $tokenName
     *
     * @return bool
     */
    public function is($tokenName);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getValue();
}
