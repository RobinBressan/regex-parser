<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class RepetitionNode extends AbstractNode
{
    /**
     * @param int|null $min
     * @param int|null $max
     * @param array    $childNodes
     */
    public function __construct($min, $max, array $childNodes)
    {
        parent::__construct('repetition', array(
            'min' => $min,
            'max' => $max,
        ), $childNodes);
    }

    /**
     * @return int|null
     */
    public function getMin()
    {
        return $this->value['min'];
    }

    /**
     * @return int|null
     */
    public function getMax()
    {
        return $this->value['max'];
    }
}
