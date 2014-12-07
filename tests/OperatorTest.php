<?php
namespace YUti\OpChecker;

class OperatorTest extends \PHPUnit_Framework_TestCase
{
    public function testApplyTo()
    {
        $operator = new Operator('==', function ($a, $b) { return $a == $b; });

        $this->assertTrue($operator->applyTo(array(1, 1)));
        $this->assertFalse($operator->applyTo(array(1, 2)));
    }
}
