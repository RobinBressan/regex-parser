<?php

namespace RegexParser;

use RegexParser\Parser\NodeInterface;

/**
 * ...
 */
abstract class AbstractGenerator implements GeneratorInterface
{
    /**
     * [$ast description]
     *
     * @var NodeInterface
     */
    protected $ast;

    /**
     * [__construct description]
     *
     * @param NodeInterface $ast [description]
     */
    public function __construct(NodeInterface $ast)
    {
        $this->ast = $ast;
    }
}
