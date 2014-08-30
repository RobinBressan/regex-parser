<?php

namespace RegexParser;

interface DomableInterface
{
    public function getDomNode(\DomDocument $document);
}
