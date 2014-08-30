<?php

namespace RegexParser\Parser\ParserPass;

use RegexParser\Lexer\TokenInterface;
use RegexParser\Parser\Node\CommentNode;
use RegexParser\Parser\Node\RepetitionNode;
use RegexParser\Parser\Exception\ParserException;
use RegexParser\Parser\AbstractParserPass;
use RegexParser\StreamInterface;
use RegexParser\Stream;

class RepetitionParserPass extends AbstractParserPass
{
    public function parseStream(StreamInterface $stream)
    {
        $blockFound = false;
        $stack = array(
            0 => array(),
            1 => array()
        );
        $step = 0;
        $result = array();

        while ($token = $stream->next()) {
            if ($stream->cursor() < 1 || !($token instanceof TokenInterface)) {
                $result[] = $token;
                continue;
            }

            // Looking for `*` pattern
            if ($token->is('T_MULTIPLY')) {
                // We remove the last token
                array_pop($result);
                $result[] = new RepetitionNode(0, null, array($stream->readAt(-1)));
            } else if ($token->is('T_PLUS')) { // Looking for `+` pattern
                // We remove the last token
                array_pop($result);
                $result[] = new RepetitionNode(1, null, array($stream->readAt(-1)));
            } else if ($token->is('T_QUESTION')) { // Looking for `?` pattern
                // We remove the last token
                array_pop($result);
                $result[] = new RepetitionNode(0, 1, array($stream->readAt(-1)));
            } else if ($token->is('T_LEFT_BRACE')) {
                $blockFound = true;
            } else if ($blockFound && $token->is('T_INTEGER')) {
                $stack[$step][] = $token;
            } else if ($blockFound && $step === 0 && $token->is('T_COMMA')) {
                $step++;
            } else if ($blockFound && $token->is('T_RIGHT_BRACE')) {
                $blockFound = false;
                array_pop($result);

                $min = (int)implode('',array_map(function($t) { return $t->getValue(); }, $stack[0]));
                $max = (int)implode('',array_map(function($t) { return $t->getValue(); }, $stack[1]));

                if ($min >= $max) {
                    throw new ParserException('Min must be greater than max in a repetition pattern');
                }

                $result[] = new RepetitionNode($min, $max, array($stream->readAt(-(count($stack[0]) + count($stack[1]) + 3))));

                $stack = array(
                    0 => array(),
                    1 => array()
                );
                $step = 0;
            } else if ($blockFound) {
                throw new ParserException('Invalid token in repetition pattern');
            } else {
                $result[] = $token;
            }
        }

        return new Stream($result);
    }
}
