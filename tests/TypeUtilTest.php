<?php
namespace YUti\OpChecker;

class TypeUtilTest extends \PHPUnit_Framework_TestCase
{
    public function testNormalizeIdent()
    {
        $type = "string";
        $normalized = TypeUtil::normalize($type);

        $this->assertEquals("string", $normalized);
    }

    public function testNormalizeCaseInsensitive()
    {
        $type = "STRING";
        $normalized = TypeUtil::normalize($type);

        $this->assertEquals("string", $normalized);
    }

    public function testNormalizeFirstChar()
    {
        $type = "s";
        $normalized = TypeUtil::normalize($type);

        $this->assertEquals("string", $normalized);
    }

    public function testNormalizeFalse()
    {
        $type = "unknown";
        $normalized = TypeUtil::normalize($type);

        $this->assertEquals(false, $normalized);
    }
}
