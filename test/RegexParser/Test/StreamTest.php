<?php

namespace RegexParser\Test;

use PHPUnit_Framework_TestCase;
use RegexParser\Stream;

class StreamTest extends PHPUnit_Framework_TestCase
{
    private $input;

    private $stream;

    public function setUp()
    {
        $this->input = array('a', 'b', 'k');
        $this->stream = new Stream($this->input);
    }

    public function testItShouldReturnTheNextDatumWhenICallNextMethod()
    {
        $this->assertEquals('a', $this->stream->next());
        $this->assertEquals('b', $this->stream->next());
        $this->assertEquals('k', $this->stream->next());
        $this->assertFalse($this->stream->next());
    }

    public function testItShouldReturnADatumRelativeToTheCurrentCursorWhenICallReadAtMethod()
    {
        $this->stream->next();
        $this->assertEquals('a', $this->stream->readAt(0));
        $this->stream->next();
        $this->assertEquals('a', $this->stream->readAt(-1));
        $this->assertEquals('k', $this->stream->readAt(1));
    }

    public function testItShouldReturnTrueIfItHasNextDatumFalseOtherwiseWhenICallHasNextMethod()
    {
        $this->assertTrue($this->stream->hasNext());
        $this->stream->next();
        $this->assertTrue($this->stream->hasNext());
        $this->stream->next();
        $this->stream->next();
        $this->assertFalse($this->stream->hasNext());
    }

    public function testItShouldReturnTheContentOfTheStreamWhenICallInputMethod()
    {
        $this->assertEquals($this->input, $this->stream->input());
    }
}
