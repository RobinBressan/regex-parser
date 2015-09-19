<?php

namespace RegexParser;

interface StreamInterface
{
    /**
     * @return mixed
     */
    public function next();

    /**
     * @param integer $index
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
     * @return boolean
     */
    public function hasNext();

    /**
     * @return integer
     */
    public function cursor();

    /**
     * @param integer $index
     * @param mixed   $value
     *
     * @return void
     */
    public function replace($index, $value);

    /**
     * @return StreamInterface
     */
    public function __clone();
}
