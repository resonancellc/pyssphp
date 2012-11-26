<?php

use pyssphp\String;

class StringTest extends PHPUnit_Framework_TestCase
{
    public function testIntegerAsOffset()
    {
        $s = new String('abcdef');
        $this->assertEquals('a', $s[0]);
        $this->assertEquals('b', $s[1]);
        $this->assertEquals('c', $s[2]);
    }

    public function testNegativeOffset()
    {
        $s = new String('abcdef');
        $this->assertEquals('f', $s[-1]);
        $this->assertEquals('e', $s[-2]);
        $this->assertEquals('d', $s[-3]);
    }

    public function testOffsetAndUnicode()
    {
        $s = new String('é_è');
        $this->assertEquals('é', $s[0]);
        $this->assertEquals('è', $s[2]);
        $this->assertEquals('è', $s[-1]);
    }

    public function testNoIndex()
    {
        $s = new String('abcdef');
        $this->assertEquals('abcdef', $s[':']);
        $this->assertEquals('abcdef', $s['::']);
    }

    public function testOnlyFirstIndex()
    {
        $s = new String('abcdef');
        $this->assertEquals('b', $s['1']);
        $this->assertEquals('bcdef', $s['1:']);
        $this->assertEquals('bcdef', $s['1::']);
        $this->assertEquals('cdef', $s['2::']);
        $this->assertEquals('abcdef', $s['0:']);
    }

    public function testNegativeFirstIndex()
    {
        $s = new String('abcdef');
        $this->assertEquals('d', $s['-3']);
        $this->assertEquals('def', $s['-3:']);
        $this->assertEquals('def', $s['-3::']);
        $this->assertEquals('ef', $s['-2::']);
    }

    public function testFirstIndexAndUnicode()
    {
        $s = new String('(é_è)');
        $this->assertEquals('é', $s['1']);
        $this->assertEquals('é_è)', $s['1:']);
        $this->assertEquals('é_è)', $s['1::']);
        $this->assertEquals('è', $s['-2']);
        $this->assertEquals('è)', $s['-2:']);
        $this->assertEquals('è)', $s['-2::']);
    }

    public function testOnlySecondIndex()
    {
        $s = new String('abcdef');
        $this->assertEquals('', $s[':0:']);
        $this->assertEquals('a', $s[':1:']);
        $this->assertEquals('ab', $s[':2:']);
    }

    public function testNegativeSecondIndex()
    {
        $s = new String('abcdef');
        $this->assertEquals('abcd', $s[':-2:']);
        $this->assertEquals('abcde', $s[':-1:']);
    }

    public function testSecondIndexAndUnicode()
    {
        $s = new String('(é_è)');
        $this->assertEquals('', $s[':0:']);
        $this->assertEquals('(', $s[':1:']);
        $this->assertEquals('(é', $s[':2:']);
        $this->assertEquals('(é_', $s[':-2:']);
        $this->assertEquals('(é_è', $s[':-1:']);
    }

    public function testBothFirstIndexes()
    {
        $s = new String('abcdef');
        $this->assertEquals('', $s['0:0']);
        $this->assertEquals('a', $s['0:1']);
        $this->assertEquals('a', $s['0:1:']);
        $this->assertEquals('bc', $s['1:3']);
        $this->assertEquals('bc', $s['1:3:']);
        $this->assertEquals('', $s['1:1']);
        $this->assertEquals('', $s['3:1']);
    }

    public function testBothNegativeFirstIndexes()
    {
        $s = new String('abcdef');
        $this->assertEquals('', $s['-4:0']);
        $this->assertEquals('', $s['-4:1']);
        $this->assertEquals('cd', $s['-4:4']);
        $this->assertEquals('cd', $s['2:-2']);
        $this->assertEquals('c', $s['2:-3']);
        $this->assertEquals('', $s['2:-4']);
        $this->assertEquals('de', $s['-3:-1']);
        $this->assertEquals('', $s['-1:-3']);
    }

    public function testBothFirstIndexesAndUnicode()
    {
        $s = new String('(é_è)');
        $this->assertEquals('é', $s['1:2']);
        $this->assertEquals('é_è', $s['-4:-1']);
    }

    public function testOnlyLastIndex()
    {
        $s = new String('abcdef');
        $this->assertEquals('abcdef', $s['::1']);
        $this->assertEquals('ace', $s['::2']);
        $this->assertEquals('ad', $s['::3']);
    }

    public function testNegativeLastIndex()
    {
        $s = new String('abcdef');
        $this->assertEquals('fedcba', $s['::-1']);
        $this->assertEquals('fdb', $s['::-2']);
        $this->assertEquals('fc', $s['::-3']);
    }

    public function testLastIndexAndUnicode()
    {
        $s = new String('é_è');
        $this->assertEquals('é_è', $s['::1']);
        $this->assertEquals('éè', $s['::2']);
        $this->assertEquals('é', $s['::3']);
        $this->assertEquals('è_é', $s['::-1']);
    }

    public function testErrorWhenLastIndexIsZero()
    {
        $s = new String('abcdef');

        $this->setExpectedException('\Hoa\String\Exception');
        $s['::0'];
    }

    public function testFirstAndLastIndexes()
    {
        $s = new String('abcdef');
        $this->assertEquals('abcdef', $s['0::1']);
        $this->assertEquals('cdef', $s['2::1']);
        $this->assertEquals('ce', $s['2::2']);
    }

    public function testNegativeFirstAndLastIndexes()
    {
        $s = new String('abcdef');
        $this->assertEquals('ce', $s['-4::2']);
        $this->assertEquals('cba', $s['2::-1']);
        $this->assertEquals('ca', $s['2::-2']);
        $this->assertEquals('edcba', $s['-2::-1']);
    }

    public function testSecondAndLastIndexes()
    {
        $s = new String('abcdef');
        $this->assertEquals('', $s[':0:1']);
        $this->assertEquals('ab', $s[':2:1']);
        $this->assertEquals('a', $s[':2:2']);
        $this->assertEquals('abcd', $s[':4:1']);
        $this->assertEquals('ac', $s[':4:2']);
    }

    public function testNegativeSecondAndLastIndexes()
    {
        $s = new String('abcdef');
        $this->assertEquals('abcd', $s[':-2:1']);
        $this->assertEquals('ac', $s[':-2:2']);
        $this->assertEquals('fedcb', $s[':0:-1']);
        $this->assertEquals('fedc', $s[':1:-1']);
        $this->assertEquals('fe', $s[':-3:-1']);
    }

    public function testAllIndexes()
    {
        $s = new String('abcdef');
        $this->assertEquals('abc', $s['0:3:1']);
        $this->assertEquals('bc', $s['1:3:1']);
        $this->assertEquals('bd', $s['1:5:2']);
    }

    public function testAllNegativeIndexes()
    {
        $s = new String('abcdef');
        $this->assertEquals('fedcb', $s['5:0:-1']);
        $this->assertEquals('edcb', $s['-2:0:-1']);
        $this->assertEquals('ed', $s['-2:2:-1']);
        $this->assertEquals('ec', $s['-2:0:-2']);
        $this->assertEquals('edc', $s['-2:-5:-1']);
        $this->assertEquals('bd', $s['-5:-1:2']);
        $this->assertEquals('', $s['-1:-5:2']);
    }

    public function testEachIndexOutOfRange()
    {
        $s = new String('abcdef');
        $this->assertEquals('', $s['50::']);
        $this->assertEquals('abcdef', $s['-50::']);
        $this->assertEquals('abcdef', $s[':50:']);
        $this->assertEquals('', $s[':-50:']);
        $this->assertEquals('a', $s['::50']);
        $this->assertEquals('f', $s['::-50']);
    }

    public function testIndexesOutOfRange()
    {
        $s = new String('abcdef');
        $this->assertEquals('f', $s['50::-50']);
        $this->assertEquals('a', $s['-50::50']);
        $this->assertEquals('f', $s[':-50:-50']);
        $this->assertEquals('abc', $s['-50:3:']);
        $this->assertEquals('ba', $s['1:-50:-1']);
        $this->assertEquals('', $s['-50:-50:2']);
    }
}