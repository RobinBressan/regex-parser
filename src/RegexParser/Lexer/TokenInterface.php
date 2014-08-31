<?php

namespace RegexParser\Lexer;

use RegexParser\DomableInterface;

interface TokenInterface
{
    public function is($tokenName);

    public function getName();

    public function getValue();
}
