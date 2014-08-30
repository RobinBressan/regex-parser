<?php

namespace RegexParser\Parser\ParserPass;

use RegexParser\Lexer\TokenInterface;
use RegexParser\Parser\Node\AlternativeNode;
use RegexParser\Parser\AbstractParserPass;
use RegexParser\StreamInterface;
use RegexParser\Stream;

class AlternativeParserPass extends AbstractParserPass
{
    public function parseStream(StreamInterface $stream)
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
                $result[] = new AlternativeNode($stream->readAt(-1), $stream->next());
            } else {
                $result[] = $token;
            }
        }

        return new Stream($result);
    }
}
