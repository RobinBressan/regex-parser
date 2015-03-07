<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

/**
 * ...
 */
class ASTNode extends AbstractNode
{
    /**
     * [__construct description]
     *
     * @param array $childNodes [description]
     */
    public function __construct(array $childNodes)
    {
        parent::__construct('ast', null, $childNodes);
    }
}
