<?php

namespace RegexParser\Parser;

use RegexParser\DomableInterface;

interface NodeInterface extends DomableInterface
{
    public function getName();

    public function getValue();

    public function getChildNodes();
}
