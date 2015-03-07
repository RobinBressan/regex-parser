<?php

namespace RegexParser\Parser;

/**
 * ...
 */
abstract class AbstractNode implements NodeInterface
{
    /**
     * [$childNodes description]
     *
     * @var array
     */
    protected $childNodes = array();

    /**
     * [$name description]
     *
     * @var string
     */
    protected $name;

    /**
     * [$value description]
     *
     * @var null|mixed
     */
    protected $value = null;

    /**
     * [$parent description]
     *
     * @var null
     */
    protected $parent = null;

    /**
     * [__construct description]
     *
     * @param string $name       [description]
     * @param mixed  $value      [description]
     * @param array  $childNodes [description]
     */
    public function __construct($name, $value, $childNodes = array())
    {
        $this->name = $name;
        $this->value = $value;
        $this->childNodes = $childNodes;

        foreach ($this->childNodes as $childNode) {
            $childNode->setParent($this);
        }
    }

    /**
     * [getParent description]
     *
     * @return NodeInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * [setParent description]
     *
     * @param NodeInterface $parent [description]
     *
     * @return void
     */
    public function setParent(NodeInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * [getName description]
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * [getValue description]
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * [getChildNodes description]
     *
     * @return array
     */
    public function getChildNodes()
    {
        return $this->childNodes;
    }

    /**
     * [appendChild description]
     *
     * @param NodeInterface $childNode [description]
     *
     * @return void
     */
    public function appendChild(NodeInterface $childNode)
    {
        $this->childNodes[] = $childNode;
    }
}
