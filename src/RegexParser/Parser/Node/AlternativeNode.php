<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class AlternativeNode extends AbstractNode
{
    protected $isSubPattern;

    public function __construct(array $childNodes) {
        parent::__construct('alternative', null, $childNodes);
    }
}
