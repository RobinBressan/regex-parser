<?php

namespace RegexParser\Parser;

use RegexParser\DomableInterface;

interface NodeInterface
{
    public function getName();

    public function getValue();

    public function getChildNodes();

    public function appendChild(NodeInterface $childNode);

    public function getParent();

    public function setParent(NodeInterface $parent);
}
