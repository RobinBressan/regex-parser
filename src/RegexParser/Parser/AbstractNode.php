<?php

namespace RegexParser\Parser;

abstract class AbstractNode implements NodeInterface
{
    /**
     * @var array
     */
    protected $childNodes = array();

    /**
     * @var string
     */
    protected $name;

    /**
     * @var null|mixed
     */
    protected $value = null;

    /**
     * @var null
     */
    protected $parent = null;

    /**
     * @param string $name
     * @param mixed  $value
     * @param array  $childNodes
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
     * @return NodeInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param NodeInterface $parent
     *
     * @return void
     */
    public function setParent(NodeInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function getChildNodes()
    {
        return $this->childNodes;
    }

    /**
     * @param NodeInterface $childNode
     *
     * @return void
     */
    public function appendChild(NodeInterface $childNode)
    {
        $this->childNodes[] = $childNode;
    }
}
