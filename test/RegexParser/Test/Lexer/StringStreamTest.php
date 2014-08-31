<?php

namespace RegexParser\Test;

use RegexParser\Lexer\StringStream;

class StringStreamTest extends \PHPUnit_Framework_TestCase
{
    private $input;

    private $protected;

    public function setUp()
    {
        $this->input = 'abc';
        $this->stream = new StringStream($this->input);
    }

    public function testItShouldConvertTheInputToArray()
    {
        $this->assertEquals(array('a', 'b', 'c'), $this->stream->input(), $this->stream->next());
    }
}
