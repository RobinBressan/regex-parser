<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class ExclusionNode extends AbstractNode
{
    /**
     * @param array $childNodes
     */
    public function __construct(array $childNodes)
    {
        parent::__construct('exclusion', null, $childNodes);
    }
}
