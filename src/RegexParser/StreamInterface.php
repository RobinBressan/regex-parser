<?php

namespace RegexParser;

/**
 * ...
 */
interface StreamInterface
{
    /**
     * [next description]
     *
     * @return mixed
     */
    public function next();

    /**
     * [readAt description]
     *
     * @param integer $index [description]
     *
     * @return mixed
     */
    public function readAt($index);

    /**
     * [current description]
     *
     * @return mixed
     */
    public function current();

    /**
     * [input description]
     *
     * @return array
     */
    public function input();

    /**
     * [hasNext description]
     *
     * @return boolean
     */
    public function hasNext();

    /**
     * [cursor description]
     *
     * @return integer
     */
    public function cursor();

    /**
     * [replace description]
     *
     * @param integer $index [description]
     * @param mixed   $value [description]
     *
     * @return void
     */
    public function replace($index, $value);

    /**
     * [__clone description]
     *
     * @return StreamInterface
     */
    public function __clone();
}
