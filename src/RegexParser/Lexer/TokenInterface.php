<?php

namespace RegexParser\Lexer;

interface TokenInterface
{
    public function is($tokenName);

    public function getName();

    public function getValue();
}
