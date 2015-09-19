<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class BlockNode extends AbstractNode
{
    /**
     * @var bool
     */
    protected $isSubPattern;

    /**
     * @param array $childNodes
     * @param bool  $isSubPattern
     */
    public function __construct(array $childNodes, $isSubPattern = false)
    {
        parent::__construct('block', null, $childNodes);
        $this->isSubPattern = $isSubPattern;
    }

    /**
     * @return bool
     */
    public function isSubPattern()
    {
        return $this->isSubPattern;
    }
}
