<?php

namespace RegexParser;

interface FormatterInterface
{
    public function format(StreamInterface $stream);
}
