<?php

namespace RegexParser\Test\Lexer;

use Prophecy\Argument;
use Prophecy\Promise\ReturnPromise;
use RegexParser\Lexer\Lexer;
use RegexParser\Test\ProphecyTestCase;

class LexerTest extends ProphecyTestCase
{
    public function testItShouldReturnNextTokenWhenICallNextTokenMethod()
    {
        $stringStreamProphecy = $this->prophet->prophesize('RegexParser\Lexer\StringStream');

        $input = array('^','[','_','a','-','z','0','-','9','-',']','+','(','\\','.','\\','\\');
        $inputReadAt = array('.', '\\');
        $output = array(
            'T_HAT',
            'T_LEFT_BRACKET',
            'T_UNDERSCORE',
            'T_CHAR',
            'T_MINUS',
            'T_CHAR',
            'T_INTEGER',
            'T_MINUS',
            'T_INTEGER',
            'T_MINUS',
            'T_RIGHT_BRACKET',
            'T_PLUS',
            'T_LEFT_PARENTHESIS',
            null,
            'T_CHAR',
            null,
            'T_BACKSLASH'
        );

        $stringStreamProphecy->next()->will(new ReturnPromise($input));
        $stringStreamProphecy->readAt(Argument::type('integer'))->will(new ReturnPromise($inputReadAt));

        $lexer = new Lexer($stringStreamProphecy->reveal());

        foreach ($input as $key=>$char) {
            if ($key === 13 || $key === 15) {
                // For escaping
                continue;
            }

            $token = $lexer->nextToken();
            $this->assertInstanceOf('RegexParser\Lexer\TokenInterface', $token);
            $this->assertEquals($char, $token->getValue());
            $this->assertEquals($output[$key], $token->getName());
        }

        $stringStreamProphecy->next()->shouldHaveBeenCalledTimes(17); // One call for each char and a final one which return false
        $stringStreamProphecy->readAt(Argument::type('integer'))->shouldHaveBeenCalledTimes(2); // For escaping
    }
}
