<?php

namespace RegexParser\Lexer;

class Token implements TokenInterface
{
    protected $name;

    protected $value;

    public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function is($tokenName)
    {
        return $this->name === $tokenName;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return sprintf('%s -> %s', $this->name, $this->value);
    }
}
