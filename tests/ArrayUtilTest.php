<?php
namespace YUti\OpChecker;

class ArrayUtilTest extends \PHPUnit_Framework_TestCase
{
    private function toArray(\Traversable $traversable)
    {
        $array = array();
        foreach ($traversable as $v) {
            $array[] = $v;
        }

        return $array;
    }

    public function testCartesianProduct_empty()
    {
        $arrays = array();
        $expected = array(
            array(),
        );
        $actual = ArrayUtil::cartesianProduct($arrays);

        $this->assertEquals($expected, $this->toArray($actual));
    }

    public function testCartesianProduct_oneArray()
    {
        $arrays = array(
            array(1, 2, 3),
        );
        $expected = array(
            array(1),
            array(2),
            array(3),
        );
        $actual = ArrayUtil::cartesianProduct($arrays);

        $this->assertEquals($expected, $this->toArray($actual));
    }

    public function testCartesianProduct_manyArrays()
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

        $this->assertEquals($expected, $this->toArray($actual));
    }

    public function testCartesianProduct_containsEmptyArray()
    {
        $arrays = array(
            array(1, 2, 3),
            array(),
            array(5, 6),
        );
        $expected = array();
        $actual = ArrayUtil::cartesianProduct($arrays);

        $this->assertEquals($expected, $this->toArray($actual));
    }
}
