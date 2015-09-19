<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class AlternativeNode extends AbstractNode
{
    /**
     * @var boolean
     */
    protected $isSubPattern;

    /**
     * @param array $childNodes
     */
    public function __construct(array $childNodes)
    {
        parent::__construct('alternative', null, $childNodes);
    }
}
