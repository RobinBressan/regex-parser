<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

/**
 * ...
 */
class AlternativeNode extends AbstractNode
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
     * @param array $childNodes [description]
     */
    public function __construct(array $childNodes)
    {
        parent::__construct('alternative', null, $childNodes);
    }
}
