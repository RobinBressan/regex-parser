<?php

namespace RegexParser\Parser;

/**
 * ...
 */
abstract class AbstractParserPass implements ParserPassInterface
{
    /**
     * [$parser description]
     *
     * @var Parser
     */
    protected $parser;

    /**
     * [setParser description]
     *
     * @param Parser $parser [description]
     *
     * @return void
     */
    public function setParser(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * [getName description]
     *
     * @return string
     */
    public function getName()
    {
        $className = explode('\\', get_class($this));

        return array_pop($className);
    }
}
