<?php

namespace RegexParser\Test\Parser;

use RegexParser\Parser\Parser;
use RegexParser\Formatter\XMLFormatter;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    protected $parser;

    protected $formatter;

    public function setUp()
    {
        $this->parser = Parser::create();
        $this->formatter = new XMLFormatter();
    }

    /**
     * @dataProvider patternProvider
     */
    public function testPattern($input, $expectedOutput, $filename)
    {
        $expectedOutputDOM = new \DOMDocument('1.0', 'utf-8');
        $expectedOutputDOM->preserveWhiteSpace = false;
        $expectedOutputDOM->formatOutput = false;
        $expectedOutputDOM->loadXML($expectedOutput);

        $ast = $this->parser->parse($input);
        $xml = $this->formatter->format($ast);

        $this->assertEquals(
          $expectedOutputDOM->saveXML(),
          $xml->saveXML(),
          sprintf('%s does not match the generated xml', $filename)
        );
    }

    public function patternProvider()
    {
        $data = array();

        $dirIterator = new \RecursiveDirectoryIterator(__DIR__ . '/../../../fixture/pattern');
        $iterator = new \RecursiveIteratorIterator($dirIterator, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }

            $content = file_get_contents($file->getPathName());
            $data[] = array_map('trim', explode('----', $content));
            $data[count($data) - 1][] = $file->getFilename();
        }

        return $data;
    }

}
