<?php
namespace YUti\OpChecker;

class ValueRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testNewInstance()
    {
        $instance = ValueRepository::newInstance();
        $this->assertTrue($instance instanceof ValueRepository);
    }

    public function testGetByType_exists()
    {
        $instance = ValueRepository::newInstance();
        $values = $instance->getByType('integer');
        $this->assertEquals(array(), $values);
    }

    public function testGetByType_notExists()
    {
        $instance = ValueRepository::newInstance();
        $values = $instance->getByType('xyz');
        $this->assertEquals(false, $values);
    }

    public function testPut()
    {
        $instance = ValueRepository::newInstance();
        $instance
            ->put(new NamedValue('int0', 0))
            ->put(new NamedValue('int1', 1))
            ->put(new NamedValue('float0', 0.0))
            ;
        $expectedInt = array(
            'int0' => new NamedValue('int0', 0),
            'int1' => new NamedValue('int1', 1),
        );
        $expectedFloat = array(
            'float0' => new NamedValue('float0', 0.0),
        );
        $this->assertEquals($expectedInt, $instance->getByType('integer'));
        $this->assertEquals($expectedFloat, $instance->getByType('float'));
    }
}
