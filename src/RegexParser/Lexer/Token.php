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

    public function getDomNode(\DomDocument $document)
    {
        $node = $document->createElement('token', $this->value);
        $node->setAttribute('type', $this->getXmlName());

        return $node;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return sprintf('%s -> %s', $this->name, $this->value);
    }

    private function getXmlName()
    {
        return str_replace('_', '-', strtolower(substr($this->name, 2)));
    }
}
