<?php

namespace RegexParser\Formatter;

use RegexParser\AbstractFormatter;
use RegexParser\Parser\Node\AlternativeNode;
use RegexParser\Parser\Node\BlockNode;
use RegexParser\Parser\Node\CharacterClassNode;
use RegexParser\Parser\Node\RepetitionNode;
use RegexParser\Parser\Node\TokenNode;

class XMLFormatter extends AbstractFormatter
{
    protected $document;

    protected $ast;

    public function preFormat()
    {
        $this->document = new \DomDocument('1.0', 'utf-8');
        $this->ast = $this->document->createElement('ast');
    }

    public function formatNode($node)
    {
        $this->ast->appendChild($this->_formatNode($node));
    }

    public function postFormat()
    {
        $this->document->appendChild($this->ast);

        return $this->document;
    }

    protected function createXmlNode($name, $value = null)
    {
        if ($value !== null) {
            return $this->document->createElement($name, $value);
        }

        return $this->document->createElement($name);
    }

    protected function _formatNode($node)
    {
        if ($node instanceof TokenNode) {
            $xmlNode = $this->formatTokenNode($node);
        } else if ($node instanceof AlternativeNode) {
            $xmlNode = $this->formatAlternativeNode($node);
        } else if ($node instanceof BlockNode) {
            $xmlNode = $this->formatBlockNode($node);
        } else if ($node instanceof CharacterClassNode) {
            $xmlNode = $this->formatCharacterClassNode($node);
        } else if ($node instanceof RepetitionNode) {
            $xmlNode = $this->formatRepetitionNode($node);
        }

        foreach ($node->getChildNodes() as $childNode) {
            $xmlNode->appendChild($this->_formatNode($childNode));
        }

        return $xmlNode;
    }

    protected function formatTokenNode(TokenNode $node)
    {
        $xmlNode = $this->createXmlNode('token', $node->getValue()->getValue());
        $xmlNode->setAttribute('type', str_replace('_', '-', strtolower(substr($node->getValue()->getName(), 2))));

        return $xmlNode;
    }

    protected function formatAlternativeNode(AlternativeNode $node)
    {
        $xmlNode = $this->createXmlNode($node->getName());
        $xmlNode->appendChild($this->_formatNode($node->getPrevious()));
        $xmlNode->appendChild($this->_formatNode($node->getNext()));

        return $xmlNode;
    }

    protected function formatBlockNode(BlockNode $node)
    {
        $xmlNode = $this->createXmlNode($node->getName());
        $xmlNode->setAttribute('sub-pattern', $node->isSubPattern() ? 'true' : 'false');

        return $xmlNode;
    }

    protected function formatCharacterClassNode(CharacterClassNode $node)
    {
        $xmlNode = $this->createXmlNode($node->getName());
        $xmlNode->appendChild($this->_formatNode($node->getStart()));
        $xmlNode->appendChild($this->_formatNode($node->getEnd()));

        return $xmlNode;
    }

    protected function formatRepetitionNode(RepetitionNode $node)
    {
        $xmlNode = $this->createXmlNode($node->getName());
        $xmlNode->setAttribute('min', $node->getMin());

        if ($node->getMax() !== null) {
            $xmlNode->setAttribute('max', $node->getMax());
        }

        return $xmlNode;
    }
}
