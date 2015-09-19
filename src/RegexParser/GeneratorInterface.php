<?php

namespace RegexParser;

use RegexParser\Parser\NodeInterface;

interface GeneratorInterface
{
    /**
     * @param NodeInterface $ast Abstract syntax tree.
     */
    public function __construct(NodeInterface $ast);

    /**
     * @param int $seed
     *
     * @return string
     */
    public function generate($seed = null);
}
