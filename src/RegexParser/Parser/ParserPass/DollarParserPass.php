<?php

namespace RegexParser\Parser\ParserPass;

use RegexParser\Lexer\TokenInterface;
use RegexParser\Parser\AbstractParserPass;
use RegexParser\Parser\Node\EndNode;
use RegexParser\Stream;
use RegexParser\StreamInterface;

/**
 * ...
 */
class DollarParserPass extends AbstractParserPass
{
    /**
     * [parseStream description]
     *
     * @param StreamInterface $stream     [description]
     * @param string|null     $parentPass [description]
     *
     * @return Stream
     */
    public function parseStream(StreamInterface $stream, $parentPass = null)
    {
        $result = array();

        while ($token = $stream->next()) {
            $result[] = $token;
        }

        // Looking for `$` pattern
        if ($result[count($result) - 1] instanceof TokenInterface &&
            $result[count($result) - 1]->is('T_DOLLAR') &&
            count($result) > 1) {
            $result[count($result) - 2] = new EndNode(
                $this
                        ->parser
                        ->parseStream(new Stream(array($result[count($result) - 2])))
                        ->input()
            );
            array_pop($result);
        }

        unset($stream);

        return new Stream($result);
    }
}
