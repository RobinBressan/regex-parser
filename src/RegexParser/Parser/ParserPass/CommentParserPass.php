<?php

namespace RegexParser\Parser\ParserPass;

use RegexParser\Lexer\TokenInterface;
use RegexParser\Parser\Exception\ParserException;
use RegexParser\Parser\AbstractParserPass;
use RegexParser\StreamInterface;
use RegexParser\Stream;

class CommentParserPass extends AbstractParserPass
{
    public function parseStream(StreamInterface $stream)
    {
        $commentFound = false;
        $stack = array();
        $result = array();

        while($token = $stream->next()) {
            if ($stream->cursor() < 2 || !($token instanceof TokenInterface)) {
                $result[] = $token;
                continue;
            }

            // Looking for `(?#` pattern
            if ($token->is('T_POUND') &&
                $stream->readAt(-1)->is('T_QUESTION') &&
                $stream->readAt(-2)->is('T_LEFT_PARENTHESIS') &&
                !$commentFound) {
                $commentFound = true;

                // We remove (? from result
                array_pop($result);
                array_pop($result);
            } else if ($commentFound && $token->is('T_RIGHT_PARENTHESIS')) {
                // $stack contains our comment but we don't keep it
                $commentFound = false;
                $stack = array();
            } else if ($commentFound) {
                $stack[] = $token;
            } else {
                $result[] = $token;
            }
        }

        if ($commentFound) {
            throw new ParserException("Comment not closed");

        }

        return new Stream($result);
    }
}
