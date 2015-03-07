<?php

namespace RegexParser\Lexer;

/**
 * ...
 */
class Token implements TokenInterface
{
    /**
     * [$name description]
     *
     * @var string
     */
    protected $name;

    /**
     * [$value description]
     *
     * @var mixed
     */
    protected $value;

    /**
     * [__construct description]
     *
     * @param string $name  [description]
     * @param mixed  $value [description]
     */
    public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * [is description]
     *
     * @param string $tokenName [description]
     *
     * @return boolean
     */
    public function is($tokenName)
    {
        return $this->name === $tokenName;
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
     * [__toString description]
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s -> %s', $this->name, $this->value);
    }
}
