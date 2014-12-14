<?php
namespace YUti\OpChecker;

class NamedValueTest extends \PHPUnit_Framework_TestCase
{
    public function testGetName()
    {
        $value = new NamedValue('integer-one', 1);

        $this->assertEquals('integer-one', $value->getName());
    }
}
