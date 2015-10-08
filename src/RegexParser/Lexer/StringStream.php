<?php

namespace RegexParser\Lexer;

use RegexParser\Stream;

class StringStream extends Stream
{
    /**
     * @param string $input
     */
    public function __construct($input)
    {
        $strlen = mb_strlen($input);
        $array = array();
        while ($strlen) {
            $array[] = mb_substr($input, 0, 1);
            $input = mb_substr($input, 1, $strlen);
            $strlen = mb_strlen($input);
        }

        parent::__construct($array);
    }
}
