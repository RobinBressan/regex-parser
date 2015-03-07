<?php

namespace RegexParser;

use RegexParser\Parser\NodeInterface;

/**
 * ...
 */
interface GeneratorInterface
{
    /**
     * [__construct description]
     *
     * @param NodeInterface $ast [description]
     */
    public function __construct(NodeInterface $ast);

    /**
     * [generate description]
     *
     * @param integer $seed [description]
     *
     * @return string
     */
    public function generate($seed = null);
}
