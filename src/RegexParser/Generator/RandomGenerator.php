<?php

namespace RegexParser\Generator;

use RegexParser\AbstractGenerator;
use RegexParser\Parser\Node\AlternativeNode;
use RegexParser\Parser\Node\BlockNode;
use RegexParser\Parser\Node\CharacterClassNode;
use RegexParser\Parser\Node\RepetitionNode;

class RandomGenerator extends AbstractGenerator
{
    public function generate($seed = null)
    {
        $output = '';

        while ($node = $this->stream->next()) {
            $output .= $this->printNode($node);
        }
    }

    protected function printNode($node)
    {
        if ($node instanceof AlternativeNode) {
            $this->printAlternativeNode($node);
        } else if ($node instanceof BlockNode) {
            $this->printBlockNode($node);
        } else if ($node instanceof CharacterClassNode) {
            $this->printCharacterClassNode($node);
        } else if ($node instanceof RepetitionNode) {
            $this->printRepetitionNode($node);
        }
    }
}
