<?php
namespace YUti\OpChecker;

class ArrayUtilTest extends \PHPUnit_Framework_TestCase
{
    public function testCartesianProduct()
    {
        $arrays = array(
            array(1, 2, 3),
            array(4),
            array(5, 6),
        );

        $expected = array(
            array(1, 4, 5),
            array(1, 4, 6),
            array(2, 4, 5),
            array(2, 4, 6),
            array(3, 4, 5),
            array(3, 4, 6),
        );

        $actual = ArrayUtil::cartesianProduct($arrays);
        $i = 0;
        foreach ($actual as $a) {
            $this->assertEquals($expected[$i++], $a);
        }
    }
}
