<?php

namespace RegexParser;

interface StreamInterface
{
    /**
     * @return mixed
     */
    public function next();

    /**
     * @param int $index
     *
     * @return mixed
     */
    public function readAt($index);

    /**
     * @return mixed
     */
    public function current();

    /**
     * @return array
     */
    public function input();

    /**
     * @return bool
     */
    public function hasNext();

    /**
     * @return int
     */
    public function cursor();

    /**
     * @param int   $index
     * @param mixed $value
     */
    public function replace($index, $value);

    /**
     * @return StreamInterface
     */
    public function __clone();
}
