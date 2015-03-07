<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

/**
 * ...
 */
class CharacterClassNode extends AbstractNode
{
    /**
     * [__construct description]
     *
     * @param mixed $start [description]
     * @param mixed $end   [description]
     */
    public function __construct($start, $end)
    {
        parent::__construct('character-class', array(
            'start' => $start,
            'end'   => $end
        ));
    }

    /**
     * [getStart description]
     *
     * @return mixed
     */
    public function getStart()
    {
        return $this->value['start'];
    }

    /**
     * [getEnd description]
     *
     * @return mixed
     */
    public function getEnd()
    {
        return $this->value['end'];
    }
}
