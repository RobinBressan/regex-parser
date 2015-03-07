<?php

namespace RegexParser;

use RegexParser\Parser\NodeInterface;

/**
 * ...
 */
interface FormatterInterface
{
    /**
     * [format description]
     *
     * @param NodeInterface $ast [description]
     *
     * @return mixed
     */
    public function format(NodeInterface $ast);
}
