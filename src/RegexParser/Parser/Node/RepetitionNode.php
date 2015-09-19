<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class RepetitionNode extends AbstractNode
{
    /**
     * @param integer|null $min
     * @param integer|null $max
     * @param array        $childNodes
     */
    public function __construct($min, $max, array $childNodes)
    {
        parent::__construct('repetition', array(
            'min' => $min,
            'max' => $max
        ), $childNodes);
    }

    /**
     * @return integer|null
     */
    public function getMin()
    {
        return $this->value['min'];
    }

    /**
     * @return integer|null
     */
    public function getMax()
    {
        return $this->value['max'];
    }
}
