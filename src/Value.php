<?php
namespace YUti\OpChecker;

class Value
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __invoke()
    {
        return $this->value;
    }

    public function getType()
    {
        return TypeUtil::normalize(gettype($this->value));
    }
}
