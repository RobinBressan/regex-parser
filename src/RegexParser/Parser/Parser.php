<?php

namespace RegexParser\Parser;

use RegexParser\Lexer\Lexer;
use RegexParser\Lexer\TokenStream;
use RegexParser\Parser\ParserPass\CommentParserPass;
use RegexParser\Parser\ParserPass\BracketBlockParserPass;
use RegexParser\Parser\ParserPass\ParenthesisBlockParserPass;
use RegexParser\Parser\ParserPass\CharacterClassParserPass;
use RegexParser\Parser\ParserPass\AlternativeParserPass;
use RegexParser\Parser\ParserPass\RepetitionParserPass;
use RegexParser\Parser\ParserPass\TokenParserPass;
use RegexParser\StreamInterface;
use RegexParser\Stream;

class Parser
{
    protected $parserPasses = array();

    public static function create()
    {
        $parser = new self();
        $parser->registerParserPass(new CommentParserPass()); // will remove all comments
        $parser->registerParserPass(new BracketBlockParserPass());
        $parser->registerParserPass(new ParenthesisBlockParserPass());
        $parser->registerParserPass(new CharacterClassParserPass());
        $parser->registerParserPass(new AlternativeParserPass());
        $parser->registerParserPass(new RepetitionParserPass()); // must be the last one juste before token pass
        $parser->registerParserPass(new TokenParserPass()); // must be the last one juste before token pass

        return $parser;
    }

    public function registerParserPass(ParserPassInterface $parserPass)
    {
        $parserPass->setParser($this);
        $this->parserPasses[] = $parserPass;
    }

    public function parseStream(StreamInterface $stream, $excludedPasses = array())
    {
        foreach ($this->parserPasses as $parserPass) {
            if (!in_array($parserPass->getName(), $excludedPasses)) {
                $stream = $parserPass->parseStream($stream);
            }
        }
        return $stream;
    }

    public function parse($input)
    {
        $lexer = Lexer::create($input);
        return $this->parseStream(new TokenStream($lexer));
    }
}
