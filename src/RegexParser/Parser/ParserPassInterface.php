<?php

namespace RegexParser\Parser;

use RegexParser\StreamInterface;

interface ParserPassInterface
{
    /**
     * @param Parser $parser
     */
    public function setParser(Parser $parser);

    /**
     * @param StreamInterface $stream
     * @param string|null     $parentPass
     *
     * @return \RegexParser\Stream
     */
    public function parseStream(StreamInterface $stream, $parentPass);

    /**
     * @return string
     */
    public function getName();
}
