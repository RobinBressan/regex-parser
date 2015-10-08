<?php

namespace RegexParser;

use RegexParser\Parser\NodeInterface;

interface FormatterInterface
{
    /**
     * @param NodeInterface $ast Abstract syntax tree.
     *
     * @return mixed
     */
    public function format(NodeInterface $ast);
}
