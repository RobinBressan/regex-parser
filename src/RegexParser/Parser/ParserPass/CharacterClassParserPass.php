<?php

namespace RegexParser\Parser\ParserPass;

use RegexParser\Lexer\TokenInterface;
use RegexParser\Parser\AbstractParserPass;
use RegexParser\Parser\Node\CharacterClassNode;
use RegexParser\Parser\Node\TokenNode;
use RegexParser\Stream;
use RegexParser\StreamInterface;

class CharacterClassParserPass extends AbstractParserPass
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

        unset($stream);

        return new Stream($result);
    }

    /**
     * Checks if two tokens of a character class are valid.
     *
     * @param TokenInterface $previous
     * @param TokenInterface $next
     * @param string|null    $parentPass
     *
     * @return boolean
     */
    private function isPreviousNextTokenValid($previous, $next, $parentPass)
    {
        if ($parentPass !== 'BracketBlockParserPass') {
            return false;
        } elseif ($previous->is('T_INTEGER') && $next->is('T_INTEGER')) {
            return $previous->getValue() < $next->getValue();
        } elseif ($previous->is('T_CHAR') && $next->is('T_CHAR')) {
            if ($next->getValue() <= 'Z') { // Need to be first because Z < z

                return $previous->getValue() >= 'A';
            } elseif ($next->getValue() <= 'z') {
                return $previous->getValue() >= 'a';
            }

            return false;
        }

        return false;
    }
}
