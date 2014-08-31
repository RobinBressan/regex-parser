<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class CharacterClassNode extends AbstractNode
{
    public function __construct($start, $end) {
        parent::__construct('character-class', array(
            'start' => $start,
            'end'   => $end
        ));
    }

    public function getStart()
    {
        return $this->value['start'];
    }

    public function getEnd()
    {
        return $this->value['end'];
    }
}
