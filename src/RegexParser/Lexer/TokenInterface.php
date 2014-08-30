<?php

namespace RegexParser\Lexer;

use RegexParser\DomableInterface;

interface TokenInterface extends DomableInterface
{
    public function is($tokenName);

    public function getName();

    public function getValue();
}
