<?php

namespace RegexParser\Parser\ParserPass;

use RegexParser\Lexer\TokenInterface;
use RegexParser\Parser\Node\AlternativeNode;
use RegexParser\Parser\Node\TokenNode;
use RegexParser\Parser\AbstractParserPass;
use RegexParser\StreamInterface;
use RegexParser\Stream;

class AlternativeParserPass extends AbstractParserPass
{
    public function parseStream(StreamInterface $stream, $parentPass = null)
    {
        $result = array();

        while ($token = $stream->next()) {
            if (!($token instanceof TokenInterface)) {
                $result[] = $token;
                continue;
            }

            // Looking for `*-*` pattern
            if ($token->is('T_PIPE')) {
                if ($stream->cursor() < 1 || !$stream->hasNext()) {
                    throw new ParserException('Alternative must have a previous and a next token');
                }

                // Remove previous
                array_pop($result);

                $previous = $stream->readAt(-1);
                if ($previous instanceof TokenInterface) {
                    $previous = new TokenNode($previous);
                }


                $next = $stream->next();
                if ($next instanceof TokenInterface) {
                    $next = new TokenNode($next);
                }

                $result[] = new AlternativeNode($previous, $next);
            } else {
                $result[] = $token;
            }
        }

        return new Stream($result);
    }
}
