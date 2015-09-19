<?php

namespace RegexParser\Parser\ParserPass;

use RegexParser\Lexer\TokenInterface;
use RegexParser\Parser\AbstractParserPass;
use RegexParser\Parser\Node\BeginNode;
use RegexParser\Parser\Node\ExclusionNode;
use RegexParser\Stream;
use RegexParser\StreamInterface;

class HatParserPass extends AbstractParserPass
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
            if (!($token instanceof TokenInterface)) {
                $result[] = $token;
                continue;
            }

            // Looking for `^` pattern
            if ($token->is('T_HAT') && $stream->cursor() === 0) {
                if ($parentPass === 'BracketBlockParserPass') {
                    $childNodes = $stream->input();
                    array_shift($childNodes); // Remove ^

                    return new Stream(array(new ExclusionNode(
                        $this
                            ->parser
                            ->parseStream(new Stream($childNodes), 'BracketBlockParserPass', array(
                                'BracketBlockParserPass',
                            ))
                            ->input()
                        )));
                }

                $result[] = new BeginNode(
                    $this
                            ->parser
                            ->parseStream(new Stream(array($stream->next())))
                            ->input()
                );
            } else {
                $result[] = $token;
            }
        }

        unset($stream);

        return new Stream($result);
    }
}
