<?php

namespace RegexParser\Parser\ParserPass;

use RegexParser\Lexer\TokenInterface;
use RegexParser\Parser\AbstractParserPass;
use RegexParser\Parser\Node\TokenNode;
use RegexParser\StreamInterface;
use RegexParser\Stream;

class TokenParserPass extends AbstractParserPass
{
    public function parseStream(StreamInterface $stream, $parentPass = null)
    {
        $result = array();

        while ($token = $stream->next()) {
            if ($token instanceof TokenInterface) {
                $token = new TokenNode($token);
            }

            $result[] = $token;
        }

        return new Stream($result);
    }
}
