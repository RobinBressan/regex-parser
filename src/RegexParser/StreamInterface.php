<?php

namespace RegexParser;

interface StreamInterface
{
    public function next();

    public function readAt($index);

    public function current();

    public function input();

    public function hasNext();

    public function cursor();
}
