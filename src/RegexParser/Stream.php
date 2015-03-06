<?php

namespace RegexParser;

class Stream implements StreamInterface
{
    protected $input;

    protected $cursor;

    public function __construct(array $input)
    {
        $this->input = $input;
        $this->cursor = -1;
    }

    public function next()
    {
        if (!$this->hasNext()) {
            return false;
        }

        $this->cursor++;

        return $this->current();
    }

    public function current()
    {
        return $this->input[$this->cursor];
    }

    public function hasNext()
    {
        return $this->cursor < count($this->input) - 1;
    }

    public function readAt($index)
    {
        return $this->cursor + $index < count($this->input) ? $this->input[$this->cursor + $index] : false;
    }

    public function cursor()
    {
        return $this->cursor;
    }

    public function input()
    {
        return $this->input;
    }

    public function replace($index, $value)
    {
        $this->input[$index] = $value;
    }

    public function __clone()
    {
        return new Stream($this->input);
    }
}
