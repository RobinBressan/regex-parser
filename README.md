RegexParser
============

RegexParser is a parser for PCRE regex. It produces an AST which represents your regex.
It can help you generating some inputs which match your regex.

Installation
------------

It is available with [Composer](http://getcomposer.org):

```
composer install robinbressan/regex-parser
```

Usage
-----

To build an AST you need to create a parser:

```php
$parser = \RegexParser\Parser\Parser::create();

$ast = $parser->parse('YOUR_REGEX');
```

You can now use a formatter to convert the AST to several format (only XML is supported today):

```php
$formatter = new \RegexParser\Parser\Formatter\XMLFormatter();

$xml = $formatter->format($ast); // $xml is now an instance of DOMDocument
```

If you wish you can display it easily:
```php
$xml->formatOutput = true;
echo $xml->saveXML();
```

Because you can get a DOMDocument, you are able to use XPath engine to query your AST.

Example
-------

The regex `^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$` will produce the following AST:

```xml
<?xml version="1.0" encoding="utf-8"?>
<ast>
  <begin>
    <repetition min="1">
      <block sub-pattern="false">
        <token type="underscore">_</token>
        <character-class>
          <token type="char">a</token>
          <token type="char">z</token>
        </character-class>
        <character-class>
          <token type="integer">0</token>
          <token type="integer">9</token>
        </character-class>
        <token type="minus">-</token>
      </block>
    </repetition>
  </begin>
  <repetition min="0">
    <block sub-pattern="true">
      <token type="char">.</token>
      <repetition min="1">
        <block sub-pattern="false">
          <token type="underscore">_</token>
          <character-class>
            <token type="char">a</token>
            <token type="char">z</token>
          </character-class>
          <character-class>
            <token type="integer">0</token>
            <token type="integer">9</token>
          </character-class>
          <token type="minus">-</token>
        </block>
      </repetition>
    </block>
  </repetition>
  <token type="at">@</token>
  <repetition min="1">
    <block sub-pattern="false">
      <character-class>
        <token type="char">a</token>
        <token type="char">z</token>
      </character-class>
      <character-class>
        <token type="integer">0</token>
        <token type="integer">9</token>
      </character-class>
      <token type="minus">-</token>
    </block>
  </repetition>
  <repetition min="0">
    <block sub-pattern="true">
      <token type="char">.</token>
      <repetition min="1">
        <block sub-pattern="false">
          <character-class>
            <token type="char">a</token>
            <token type="char">z</token>
          </character-class>
          <character-class>
            <token type="integer">0</token>
            <token type="integer">9</token>
          </character-class>
          <token type="minus">-</token>
        </block>
      </repetition>
    </block>
  </repetition>
  <end>
    <block sub-pattern="true">
      <token type="char">.</token>
      <repetition min="2" max="4">
        <block sub-pattern="false">
          <character-class>
            <token type="char">a</token>
            <token type="char">z</token>
          </character-class>
        </block>
      </repetition>
    </block>
  </end>
</ast>
```

Generator
---------

You can also create a generator based on your AST which will generate a string that match your regex:

```php
$generator = new \RegexParser\Generator\RandomGenerator($ast);
$generator->generate($seed = null);
```

If you wish you can also create directly the generator :

```php
$generator = new \RegexParser\Generator\RandomGenerator::create('YOUR_REGEX');
$generator->generate($seed = null);
```

Test
----

To run the test you must run `phpunit` command.

Contributing
------------

All contributions are welcome and must pass the tests. If you add a new feature, please write tests for it.

License
-------

This application is available under the MIT License.
