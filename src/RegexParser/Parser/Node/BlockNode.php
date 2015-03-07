<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

/**
 * ...
 */
class BlockNode extends AbstractNode
{
    /**
     * [$isSubPattern description]
     *
     * @var boolean
     */
    protected $isSubPattern;

    /**
     * [__construct description]
     *
     * @param array   $childNodes   [description]
     * @param boolean $isSubPattern [description]
     */
    public function __construct(array $childNodes, $isSubPattern = false)
    {
        parent::__construct('block', null, $childNodes);
        $this->isSubPattern = $isSubPattern;
    }

    /**
     * [isSubPattern description]
     *
     * @return boolean
     */
    public function isSubPattern()
    {
        return $this->isSubPattern;
    }
}
