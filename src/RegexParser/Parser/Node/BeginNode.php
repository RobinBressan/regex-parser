<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class BeginNode extends AbstractNode
{
    /**
     * @param array $childNodes
     */
    public function __construct(array $childNodes)
    {
        parent::__construct('begin', null, $childNodes);
    }
}
