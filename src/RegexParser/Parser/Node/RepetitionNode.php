<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class RepetitionNode extends AbstractNode
{
    public function __construct($min, $max, $childNodes) {
        parent::__construct('repetition', array(
            'min' => $min,
            'max' => $max
        ), $childNodes);
    }

    public function getMin()
    {
        return $this->value['min'];
    }

    public function getMax()
    {
        return $this->value['max'];
    }

    protected function _getDomNode(\DomDocument $document, \DomNode $node)
    {
        $node->setAttribute('min', $this->getMin());

        if ($this->getMax() !== null) {
            $node->setAttribute('max', $this->getMax());
        }
    }
}
