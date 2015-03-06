<?php

namespace RegexParser\Test;

use PHPUnit_Framework_TestCase;
use Prophecy\Prophet;

class ProphecyTestCase extends PHPUnit_Framework_TestCase
{
    protected $prophet;

    protected function setUp()
    {
        $this->prophet = new Prophet();
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
