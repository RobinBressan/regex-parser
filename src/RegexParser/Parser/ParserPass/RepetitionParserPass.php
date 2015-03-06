<?php

namespace RegexParser\Parser\ParserPass;

use RegexParser\Lexer\TokenInterface;
use RegexParser\Parser\Node\RepetitionNode;
use RegexParser\Parser\Node\TokenNode;
use RegexParser\Parser\Exception\ParserException;
use RegexParser\Parser\AbstractParserPass;
use RegexParser\StreamInterface;
use RegexParser\Stream;

class RepetitionParserPass extends AbstractParserPass
{
    public function parseStream(StreamInterface $stream, $parentPass = null)
    {
        $blockFound = false;
        $stack = array(
            0 => array(),
            1 => array()
        );
        $step = 0;
        $result = array();

        while ($token = $stream->next()) {
            if (!($token instanceof TokenInterface)) {
                $result[] = $token;
                continue;
            }

            // Looking for `*` pattern
            if ($token->is('T_MULTIPLY')) {
                if ($stream->cursor() < 1) {
                    throw new ParserException('A repetition pattern must follow a token');
                }

                // We remove the last token
                array_pop($result);
                $child = $stream->readAt(-1);
                if ($child instanceof TokenInterface) {
                    $child = new TokenNode($child);
                }

                $result[] = new RepetitionNode(0, null, array($child));

                // We reinject the current node into the stream to handle case like +? and so on...
                $stream->replace($stream->cursor(), $result[count($result) - 1]);
            } elseif ($token->is('T_PLUS')) { // Looking for `+` pattern
                if ($stream->cursor() < 1) {
                    throw new ParserException('A repetition pattern must follow a token');
                }

                // We remove the last token
                array_pop($result);
                $child = $stream->readAt(-1);
                if ($child instanceof TokenInterface) {
                    $child = new TokenNode($child);
                }

                $result[] = new RepetitionNode(1, null, array($child));

                // We reinject the current node into the stream to handle case like +? and so on...
                $stream->replace($stream->cursor(), $result[count($result) - 1]);
            } elseif ($token->is('T_QUESTION')) { // Looking for `?` pattern
                if ($stream->cursor() < 1) {
                    throw new ParserException('A repetition pattern must follow a token');
                }

                // We remove the last token
                array_pop($result);
                $child = $stream->readAt(-1);
                if ($child instanceof TokenInterface) {
                    $child = new TokenNode($child);
                }

                $result[] = new RepetitionNode(0, 1, array($child));

                // We reinject the current node into the stream to handle case like +? and so on...
                $stream->replace($stream->cursor(), $result[count($result) - 1]);
            } elseif ($token->is('T_LEFT_BRACE')) {
                if ($stream->cursor() < 1) {
                    throw new ParserException('A repetition pattern must follow a token');
                }

                $blockFound = true;
            } elseif ($blockFound && $token->is('T_INTEGER')) {
                $stack[$step][] = $token;
            } elseif ($blockFound && $step === 0 && $token->is('T_COMMA')) {
                $step++;
            } elseif ($blockFound && $token->is('T_RIGHT_BRACE')) {
                $blockFound = false;
                array_pop($result);

                $min = (int) implode('',array_map(function ($t) { return $t->getValue(); }, $stack[0]));

                if (count($stack[1]) > 0) {
                    $max = (int) implode('',array_map(function ($t) { return $t->getValue(); }, $stack[1]));
                    if ($max !== null && $min >= $max) {
                        throw new ParserException('Min must be greater than max in a repetition pattern');
                    }
                    $offset = 3; // +3 because of {,}
                } else {
                    $max = $min;
                    $offset = 2;  // +3 because of {}
                }

                $child = $stream->readAt(-(count($stack[0]) + count($stack[1]) + $offset));
                if ($child instanceof TokenInterface) {
                    $child = new TokenNode($child);
                }

                $result[] = new RepetitionNode($min, $max, array($child));

                $stack = array(
                    0 => array(),
                    1 => array()
                );
                $step = 0;

                // We reinject the current node into the stream to handle case like +? and so on...
                $stream->replace($stream->cursor(), $result[count($result) - 1]);
            } elseif ($blockFound) {
                throw new ParserException('Invalid token in repetition pattern');
            } else {
                $result[] = $token;
            }
        }

        unset($stream);

        return new Stream($result);
    }
}
