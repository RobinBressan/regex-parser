<?php

namespace RegexParser;

class Stream implements StreamInterface
{
    /**
     * @var array
     */
    protected $input;

    /**
     * @var integer
     */
    protected $cursor;

    /**
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->input = $input;
        $this->cursor = -1;
    }

    /**
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
     * @return mixed
     */
    public function current()
    {
        return $this->input[$this->cursor];
    }

    /**
     * @return boolean
     */
    public function hasNext()
    {
        return $this->cursor < count($this->input) - 1;
    }

    /**
     * @param integer $index
     *
     * @return mixed|false
     */
    public function readAt($index)
    {
        return $this->cursor + $index < count($this->input) ? $this->input[$this->cursor + $index] : false;
    }

    /**
     * @return integer
     */
    public function cursor()
    {
        return $this->cursor;
    }

    /**
     * @return array
     */
    public function input()
    {
        return $this->input;
    }

    /**
     * @param integer $index
     * @param mixed   $value
     *
     * @return void
     */
    public function replace($index, $value)
    {
        $this->input[$index] = $value;
    }

    /**
     * @return Stream
     */
    public function __clone()
    {
        return new Stream($this->input);
    }
}
