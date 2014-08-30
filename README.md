regex-parser
============

RegexParser is a parser for PCRE regex. It produces a DomDocument which represents the AST of your regex.
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

$ast = $parser->parse('YOUR_REGEX'); // $ast is an instance of DomDocument
```

Example
-------

The regex `^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$` will produce the following AST:

```xml
<?xml version="1.0" encoding="utf-8"?>
<ast>
  <token type="hat">^</token>
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
  <token type="dollar">$</token>
</ast>
```

Contributing
------------

All contributions are welcome and must pass the tests. If you add a new feature, please write tests for it.

License
-------

This application is available under the MIT License.
