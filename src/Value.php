<?php
namespace YUti\OpChecker;

class Value
{
    private $name;
    private $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function name()
    {
        return $this->name;
    }

    public function get()
    {
        return $this->value;
    }

    public function type()
    {
        return TypeUtil::normalize(gettype($this->value));
    }
}
