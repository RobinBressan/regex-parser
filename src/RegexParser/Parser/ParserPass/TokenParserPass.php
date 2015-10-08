<?php

namespace RegexParser\Parser\ParserPass;

use RegexParser\Lexer\TokenInterface;
use RegexParser\Parser\AbstractParserPass;
use RegexParser\Parser\Node\TokenNode;
use RegexParser\Stream;
use RegexParser\StreamInterface;

class TokenParserPass extends AbstractParserPass
{
    /**
     * @param StreamInterface $stream
     * @param string|null     $parentPass
     *
     * @return Stream
     */
    public function parseStream(StreamInterface $stream, $parentPass = null)
    {
        $result = array();

        while ($token = $stream->next()) {
            if ($token instanceof TokenInterface) {
                $token = new TokenNode($token);
            }

            $result[] = $token;
        }

        unset($stream);

        return new Stream($result);
    }
}
