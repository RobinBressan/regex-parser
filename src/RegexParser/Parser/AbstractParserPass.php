<?php

namespace RegexParser\Parser;

abstract class AbstractParserPass implements ParserPassInterface
{
    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @param Parser $parser
     *
     * @return void
     */
    public function setParser(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @return string
     */
    public function getName()
    {
        $className = explode('\\', get_class($this));

        return array_pop($className);
    }
}
