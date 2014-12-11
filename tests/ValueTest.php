<?php
namespace YUti\OpChecker;

class ValueTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $value = new Value(1);
        $this->assertEquals(1, $value->get());
    }

    public function testType()
    {
        $value = new Value(1);
        $this->assertEquals('integer', $value->type());
    }
}
