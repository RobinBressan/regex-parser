<?php

namespace RegexParser\Parser;

use RegexParser\StreamInterface;

interface ParserPassInterface
{
    public function setParser(Parser $parse);

    public function parseStream(StreamInterface $stream);

    public function getName();
}
