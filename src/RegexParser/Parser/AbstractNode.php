<?php

namespace RegexParser\Parser;

use RegexParser\Lexer\TokenInterface;

abstract class AbstractNode implements NodeInterface
{
    protected $childNodes = array();

    protected $name;

    protected $value = null;

    public function __construct($name, $value, $childNodes = array())
    {
        $this->name = $name;
        $this->value = $value;
        $this->childNodes = $childNodes;
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

    public function getDomNode(\DomDocument $document)
    {
        $domNode = $document->createElement($this->name);

        $return = $this->_getDomNode($document, $domNode);

        if ($return instanceof \DomNode) {
            $domNode = $return;
        }

        foreach ($this->childNodes as $childNode) {
            $domNode->appendChild($childNode->getDomNode($document));
        }

        return $domNode;
    }

    protected abstract function _getDomNode(\DomDocument $document, \DomNode $node);
}
