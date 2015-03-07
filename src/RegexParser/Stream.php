<?php

namespace RegexParser;

/**
 * ...
 */
class Stream implements StreamInterface
{
    /**
     * [$input description]
     *
     * @var array
     */
    protected $input;

    /**
     * [$cursor description]
     *
     * @var integer
     */
    protected $cursor;

    /**
     * [__construct description]
     *
     * @param array $input [description]
     */
    public function __construct(array $input)
    {
        $this->input = $input;
        $this->cursor = -1;
    }

    /**
     * [next description]
     *
     * @return mixed
     */
    public function next()
    {
        if (!$this->hasNext()) {
            return false;
        }

        $this->cursor++;

        return $this->current();
    }

    /**
     * [current description]
     *
     * @return mixed
     */
    public function current()
    {
        return $this->input[$this->cursor];
    }

    /**
     * [hasNext description]
     *
     * @return boolean
     */
    public function hasNext()
    {
        return $this->cursor < count($this->input) - 1;
    }

    /**
     * [readAt description]
     *
     * @param integer $index [description]
     *
     * @return mixed|false
     */
    public function readAt($index)
    {
        return $this->cursor + $index < count($this->input) ? $this->input[$this->cursor + $index] : false;
    }

    /**
     * [cursor description]
     *
     * @return integer
     */
    public function cursor()
    {
        return $this->cursor;
    }

    /**
     * [input description]
     *
     * @return array
     */
    public function input()
    {
        return $this->input;
    }

    /**
     * [replace description]
     *
     * @param integer $index [description]
     * @param mixed   $value [description]
     *
     * @return void
     */
    public function replace($index, $value)
    {
        $this->input[$index] = $value;
    }

    /**
     * [__clone description]
     *
     * @return Stream
     */
    public function __clone()
    {
        return new Stream($this->input);
    }
}
