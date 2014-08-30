<?php

namespace RegexParser\Parser;

use RegexParser\Lexer\Lexer;
use RegexParser\Parser\ParserPass\CommentParserPass;
use RegexParser\Parser\ParserPass\BracketBlockParserPass;
use RegexParser\Parser\ParserPass\ParenthesisBlockParserPass;
use RegexParser\Parser\ParserPass\CharacterClassParserPass;
use RegexParser\Parser\ParserPass\AlternativeParserPass;
use RegexParser\Parser\ParserPass\RepetitionParserPass;
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
        $parser->registerParserPass(new RepetitionParserPass()); // must be the last one

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

        $tokens = array();
        while ($token = $lexer->nextToken()) {
            $tokens[] = $token;
        }

        return $this->buildDomDocument(
            $this->parseStream(new Stream($tokens))
        );
    }

    private function buildDomDocument(StreamInterface $stream)
    {
        $document = new \DomDocument('1.0', 'utf-8');
        $ast = $document->createElement('ast');

        while ($node = $stream->next()) {
            $ast->appendChild($node->getDomNode($document));
        }

        $document->appendChild($ast);

        return $document;
    }
}
