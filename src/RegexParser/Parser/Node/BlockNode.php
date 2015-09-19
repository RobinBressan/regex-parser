<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class BlockNode extends AbstractNode
{
    /**
     * @var boolean
     */
    protected $isSubPattern;

    /**
     * @param array   $childNodes
     * @param boolean $isSubPattern
     */
    public function __construct(array $childNodes, $isSubPattern = false)
    {
        parent::__construct('block', null, $childNodes);
        $this->isSubPattern = $isSubPattern;
    }

    /**
     * @return boolean
     */
    public function isSubPattern()
    {
        return $this->isSubPattern;
    }
}
