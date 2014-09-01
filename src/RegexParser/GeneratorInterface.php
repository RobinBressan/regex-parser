<?php

namespace RegexParser;

interface GeneratorInterface
{
    public function __construct(StreamInterface $stream);

    public function generate($seed = null);
}
