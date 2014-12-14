<?php
namespace YUti\OpChecker;

class CheckerTest extends \PHPUnit_Framework_TestCase
{
    public function testCheck()
    {
        $argv = array('', '==', 'i', 'b');
        $checker = new Checker();

        $this->expectOutputString(
            'integer.0 == boolean.false : 1' . "\n"
            . 'integer.0 == boolean.true : ' . "\n"
            . 'integer.1 == boolean.false : ' . "\n"
            . 'integer.1 == boolean.true : 1' . "\n"
        );

        $checker->check($argv);
    }
}
