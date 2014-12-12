<?php
namespace YUti\OpChecker;

class ValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $value = new Value(1);
        $this->assertEquals(1, $value());
    }

    public function testGetType()
    {
        $value = new Value(1);
        $this->assertEquals('integer', $value->getType());
    }
}
