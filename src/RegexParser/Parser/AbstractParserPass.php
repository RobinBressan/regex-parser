<?php

namespace RegexParser\Parser;

abstract class AbstractParserPass implements ParserPassInterface
{
    protected $parser;

    public function setParser(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function getName()
    {
        $className = explode('\\', get_class($this));

        return array_pop($className);
    }
}
