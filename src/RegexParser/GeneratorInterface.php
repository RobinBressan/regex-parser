<?php

namespace RegexParser;

use RegexParser\Parser\NodeInterface;

interface GeneratorInterface
{
    public function __construct(NodeInterface $ast);

    public function generate($seed = null);
}
