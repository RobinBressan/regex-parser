<?php

namespace RegexParser;

use RegexParser\Parser\NodeInterface;

interface FormatterInterface
{
    public function format(NodeInterface $ast);
}
