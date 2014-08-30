<?php

namespace RegexParser\Parser\ParserPass;

use RegexParser\Lexer\TokenInterface;
use RegexParser\Parser\Node\CharacterClassNode;
use RegexParser\Parser\AbstractParserPass;
use RegexParser\StreamInterface;
use RegexParser\Stream;

class CharacterClassParserPass extends AbstractParserPass
{
    public function parseStream(StreamInterface $stream)
    {
        $result = array();

        while ($token = $stream->next()) {
            if ($stream->cursor() < 2 || !($token instanceof TokenInterface)) {
                $result[] = $token;
                continue;
            }

            // Looking for `*-*` pattern
            if (($token->is('T_CHAR') || $token->is('T_INTEGER')) &&
                $stream->readAt(-1) instanceof TokenInterface &&
                $stream->readAt(-1)->is('T_MINUS') &&
                $stream->readAt(-2) instanceof TokenInterface &&
                ($stream->readAt(-2)->is('T_CHAR') || $stream->readAt(-2)->is('T_INTEGER'))) {

                // Remove *-
                array_pop($result);
                array_pop($result);

                $result[] = new CharacterClassNode($stream->readAt(-2), $token);
            } else {
                $result[] = $token;
            }
        }

        return new Stream($result);
    }
}
