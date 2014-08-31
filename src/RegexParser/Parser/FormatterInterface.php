<?php

namespace RegexParser\Parser;

use RegexParser\StreamInterface;

interface FormatterInterface
{
    public function format(StreamInterface $stream);
}
