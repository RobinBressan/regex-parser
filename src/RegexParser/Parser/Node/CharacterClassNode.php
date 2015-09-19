<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class CharacterClassNode extends AbstractNode
{
    /**
     * @param mixed $start
     * @param mixed $end
     */
    public function __construct($start, $end)
    {
        parent::__construct('character-class', array(
            'start' => $start,
            'end'   => $end
        ));
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->value['start'];
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->value['end'];
    }
}
