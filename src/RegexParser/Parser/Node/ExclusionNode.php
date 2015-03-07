<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

/**
 * ...
 */
class ExclusionNode extends AbstractNode
{
    /**
     * [__construct description]
     *
     * @param array $childNodes [description]
     */
    public function __construct(array $childNodes)
    {
        parent::__construct('exclusion', null, $childNodes);
    }
}
