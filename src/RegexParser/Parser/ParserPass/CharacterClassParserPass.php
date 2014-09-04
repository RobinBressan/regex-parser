<?php

namespace RegexParser\Parser\ParserPass;

use RegexParser\Lexer\TokenInterface;
use RegexParser\Parser\Node\CharacterClassNode;
use RegexParser\Parser\Node\TokenNode;
use RegexParser\Parser\AbstractParserPass;
use RegexParser\StreamInterface;
use RegexParser\Stream;

class CharacterClassParserPass extends AbstractParserPass
{
    public function parseStream(StreamInterface $stream, $parentPass = null)
    {
        $result = array();
        $used = array();

        while ($token = $stream->next()) {
            if ($stream->cursor() < 1 || !($token instanceof TokenInterface)) {
                $result[] = $token;
                continue;
            }

            // Looking for `*-*` pattern
            if ($token->is('T_MINUS') &&
                $stream->readAt(-1) instanceof TokenInterface &&
                $stream->readAt(1) instanceof TokenInterface &&
                !in_array($stream->cursor() - 1, $used) &&
                $this->isPreviousNextTokenValid($stream->readAt(-1), $stream->readAt(1), $parentPass)
            ) {

                // Remove *
                array_pop($result);

                $used[] = $stream->cursor();
                $used[] = $stream->cursor() - 1;
                $used[] = $stream->cursor() + 1;

                $result[] = new CharacterClassNode(new TokenNode($stream->readAt(-1)), new TokenNode($stream->readAt(1)));
                $stream->next();
            } else {
                $result[] = $token;
            }
        }

        return new Stream($result);
    }

    /**
     * Valid that the two tokens of a character class are valid
     * @param  TokeInterface   $previous
     * @param  TokenInterface  $next
     * @return boolean
     */
    private function isPreviousNextTokenValid($previous, $next, $parentPass)
    {
        if ($parentPass !== 'BracketBlockParserPass') {
            return false;
        } else if ($previous->is('T_INTEGER') && $next->is('T_INTEGER')) {
            return $previous->getValue() < $next->getValue();
        } else if ($previous->is('T_CHAR') && $next->is('T_CHAR')) {
            if ($next->getValue() <= 'Z') { // Need to be first because Z < z
                return $previous->getValue() >= 'A';
            } else if ($next->getValue() <= 'z') {
                return $previous->getValue() >= 'a';
            }

            return false;
        }

        return false;
    }
}
