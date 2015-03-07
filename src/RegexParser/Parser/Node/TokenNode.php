<?php

namespace RegexParser\Parser\Node;

use RegexParser\Parser\AbstractNode;

/**
 * ...
 */
class TokenNode extends AbstractNode
{
    /**
     * [__construct description]
     *
     * @param mixed $token [description]
     */
    public function __construct($token)
    {
        parent::__construct('token', $token);
    }
}
