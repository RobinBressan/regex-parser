<?php

namespace RegexParser;

abstract class AbstractFormatter implements FormatterInterface
{
    public function format(StreamInterface $stream)
    {
        $stream = clone($stream);

        $this->preFormat();

        while ($node = $stream->next()) {
            $this->formatNode($node);
        }

        return  $this->postFormat();;
    }

    abstract protected function preFormat();

    abstract protected function formatNode($node);

    abstract protected function postFormat();
}
