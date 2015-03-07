<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

/**
 * ...
 */
class RepetitionNode extends AbstractNode
{
    /**
     * [__construct description]
     *
     * @param integer|null $min        [description]
     * @param integer|null $max        [description]
     * @param array        $childNodes [description]
     */
    public function __construct($min, $max, array $childNodes)
    {
        parent::__construct('repetition', array(
            'min' => $min,
            'max' => $max
        ), $childNodes);
    }

    /**
     * [getMin description]
     *
     * @return integer|null
     */
    public function getMin()
    {
        return $this->value['min'];
    }

    /**
     * [getMax description]
     *
     * @return integer|null
     */
    public function getMax()
    {
        return $this->value['max'];
    }
}
