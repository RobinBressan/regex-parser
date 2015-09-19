<?php

namespace RegexParser;

use RegexParser\Parser\NodeInterface;

abstract class AbstractGenerator implements GeneratorInterface
{
    /**
     * @var NodeInterface
     */
    protected $ast;

    /**
     * @param NodeInterface $ast Abstract syntax tree.
     */
    public function __construct(NodeInterface $ast)
    {
        $this->ast = $ast;
    }
}
