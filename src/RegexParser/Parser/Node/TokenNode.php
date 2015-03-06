<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

class TokenNode extends AbstractNode
{
    public function __construct($token)
    {
        parent::__construct('token', $token);
    }
}
