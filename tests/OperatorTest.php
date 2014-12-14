<?php
namespace YUti\OpChecker;

class OperatorTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $operator = new Operator('==', function ($a, $b) { return $a == $b; });

        $this->assertTrue($operator(array(1, 1)));
        $this->assertFalse($operator(array(1, 2)));
    }

    public function testGetSymbol()
    {
        $operator = new Operator('==', function ($a, $b) { return $a == $b; });

        $this->assertEquals('==', $operator->getSymbol());
    }

    public function testGetFunction()
    {
        $operator = new Operator('==', function ($a, $b) { return $a == $b; });
        $function = $operator->getFunction();

        $this->assertTrue($function(1, 1));
        $this->assertFalse($function(1, 2));
    }

}
