<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class AlternativeNode extends AbstractNode
{
    protected $isSubPattern;

    public function __construct($previous, $next) {
        parent::__construct('alternative', array(
            'previous' => $previous,
            'next'     => $next
        ));
    }

    public function getPrevious()
    {
        return $this->value['previous'];
    }

    public function getNext()
    {
        return $this->value['next'];
    }
}
