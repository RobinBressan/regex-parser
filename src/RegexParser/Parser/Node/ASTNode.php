<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class ASTNode extends AbstractNode
{
    public function __construct(array $childNodes)
    {
        parent::__construct('ast', null, $childNodes);
    }
}
