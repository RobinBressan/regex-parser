<?php

namespace RegexParser\Parser;

use RegexParser\Lexer\TokenInterface;

abstract class AbstractNode implements NodeInterface
{
    protected $childNodes = array();

    protected $name;

    protected $value = null;

    protected $parent = null;

    public function __construct($name, $value, $childNodes = array())
    {
        $this->name = $name;
        $this->value = $value;
        $this->childNodes = $childNodes;

        foreach ($this->childNodes as $childNode) {
            $childNode->setParent($this);
        }
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(NodeInterface $parent)
    {
        $this->parent = $parent;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getChildNodes()
    {
        return $this->childNodes;
    }

    public function appendChild(NodeInterface $childNode)
    {
        $this->childNodes[] = $childNode;
    }
}
