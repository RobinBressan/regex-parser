<?php

namespace RegexParser\Parser;

/**
 * ...
 */
interface NodeInterface
{
    /**
     * [getName description]
     *
     * @return string
     */
    public function getName();

    /**
     * [getValue description]
     *
     * @return mixed
     */
    public function getValue();

    /**
     * [getChildNodes description]
     *
     * @return array
     */
    public function getChildNodes();

    /**
     * [appendChild description]
     *
     * @param NodeInterface $childNode [description]
     *
     * @return void
     */
    public function appendChild(NodeInterface $childNode);

    /**
     * [getParent description]
     *
     * @return NodeInterface
     */
    public function getParent();

    /**
     * [setParent description]
     *
     * @param NodeInterface $parent [description]
     */
    public function setParent(NodeInterface $parent);
}
