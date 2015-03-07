<?php

namespace RegexParser\Parser;

use RegexParser\StreamInterface;

/**
 * ...
 */
interface ParserPassInterface
{
    /**
     * [setParser description]
     *
     * @param Parser $parser [description]
     */
    public function setParser(Parser $parser);

    /**
     * [parseStream description]
     *
     * @param StreamInterface $stream     [description]
     * @param string|null     $parentPass [description]
     *
     * @return \RegexParser\Stream
     */
    public function parseStream(StreamInterface $stream, $parentPass);

    /**
     * [getName description]
     *
     * @return string
     */
    public function getName();
}
