<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class EndNode extends AbstractNode
{
    public function __construct(array $childNodes)
    {
        parent::__construct('end', null, $childNodes);
    }
}
