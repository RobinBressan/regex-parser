<?php

namespace RegexParser\Formatter;

use DomDocument;
use RegexParser\AbstractFormatter;
use RegexParser\Lexer\EscapeToken;
use RegexParser\Parser\Node\AlternativeNode;
use RegexParser\Parser\Node\ASTNode;
use RegexParser\Parser\Node\BeginNode;
use RegexParser\Parser\Node\BlockNode;
use RegexParser\Parser\Node\CharacterClassNode;
use RegexParser\Parser\Node\EndNode;
use RegexParser\Parser\Node\ExclusionNode;
use RegexParser\Parser\Node\RepetitionNode;
use RegexParser\Parser\Node\TokenNode;
use RegexParser\Parser\NodeInterface;

class XMLFormatter extends AbstractFormatter
{
    protected $document;

    public function format(NodeInterface $ast)
    {
        $this->document = new DomDocument('1.0', 'utf-8');
        $this->document->appendChild($this->formatNode($ast));

        return $this->document;
    }

    protected function createXmlNode($name, $value = null)
    {
        if ($value !== null) {
            return $this->document->createElement($name, $value);
        }

        return $this->document->createElement($name);
    }

    protected function formatNode($node)
    {
        if ($node instanceof ASTNode) {
            $xmlNode = $this->formatASTNode($node);
        } elseif ($node instanceof TokenNode) {
            $xmlNode = $this->formatTokenNode($node);
        } elseif ($node instanceof AlternativeNode) {
            $xmlNode = $this->formatDefaultNode($node);
        } elseif ($node instanceof BlockNode) {
            $xmlNode = $this->formatBlockNode($node);
        } elseif ($node instanceof CharacterClassNode) {
            $xmlNode = $this->formatCharacterClassNode($node);
        } elseif ($node instanceof RepetitionNode) {
            $xmlNode = $this->formatRepetitionNode($node);
        } elseif ($node instanceof ExclusionNode) {
            $xmlNode = $this->formatDefaultNode($node);
        } elseif ($node instanceof BeginNode) {
            $xmlNode = $this->formatDefaultNode($node);
        } elseif ($node instanceof EndNode) {
            $xmlNode = $this->formatDefaultNode($node);
        }

        foreach ($node->getChildNodes() as $childNode) {
            $xmlNode->appendChild($this->formatNode($childNode));
        }

        return $xmlNode;
    }

    protected function formatASTNode(ASTNode $node)
    {
        $xmlNode = $this->createXmlNode('ast');

        return $xmlNode;
    }

    protected function formatTokenNode(TokenNode $node)
    {
        $token = $node->getValue();
        $xmlNode = $this->createXmlNode('token', $token->getValue());
        $xmlNode->setAttribute('type', str_replace('_', '-', strtolower(substr($token->getName(), 2))));

        if ($token instanceof EscapeToken) {
            $xmlNode->setAttribute('exclusion-sequence', $token->isExclusionSequence() ? 'true' : 'false');
        }

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
        $xmlNode->appendChild($this->formatNode($node->getStart()));
        $xmlNode->appendChild($this->formatNode($node->getEnd()));

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

    protected function formatDefaultNode(NodeInterface $node)
    {
        return $this->createXmlNode($node->getName());
    }
}
