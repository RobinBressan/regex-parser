<?php

namespace RegexParser\Parser;

interface NodeInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return array
     */
    public function getChildNodes();

    /**
     * @param NodeInterface $childNode
     */
    public function appendChild(NodeInterface $childNode);

    /**
     * @return NodeInterface
     */
    public function getParent();

    /**
     * @param NodeInterface $parent
     */
    public function setParent(NodeInterface $parent);
}
