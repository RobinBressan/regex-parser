<?php

namespace RegexParser;

abstract class AbstractGenerator implements GeneratorInterface
{
    protected $stream;

    public function __construct(StreamInterface $stream)
    {
        $this->stream = clone($stream);
    }
}
