<?php
namespace YUti\OpChecker;

class OperatorRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testNewInstance_withoutBuiltinOperators()
    {
        $instance = OperatorRepository::newInstance(false);

        $this->assertFalse($instance->get('=='));
    }

    public function testNewInstance_withBuiltinOperators()
    {
        $instance = OperatorRepository::newInstance();
        $operator = $instance->get('==');

        $this->assertTrue($operator(array(1, 1)));
    }

    public function testGet()
    {
        $instance = OperatorRepository::newInstance();

        $this->assertEquals('==', $instance->get('==')->getSymbol());
    }

    public function testPut()
    {
        $instance = OperatorRepository::newInstance(false);
        $instance->put(new Operator('!', function ($a) { return !$a; }));
        $operator = $instance->get('!');

        $this->assertEquals(false, $operator(array(true)));
    }
}
