# pyssphp - Python String Slice for PHP #

## What is pyssphp? ##

pyssphp is a PHP library.
It permits developers to use the Python string slice syntax.

## Server Requirements ##

- PHP version 5.3.3 or newer

## Usage ##

``` php
<?php

$s = new \pyssphp\String('pyssphp');
echo $s[':4']; // prints 'pyss'
echo $s['::2']; // prints 'pspp'

```

## Tests ##

To run the test suite, you need [composer](http://getcomposer.org) and
[PHPUnit](https://github.com/sebastianbergmann/phpunit).

    $ cd path/to/pyssphp
    $ composer.phar install --dev
    $ phpunit

## License ##

pyssphp is under the MIT license. Please, read LICENSE.