<?php
namespace YUti\OpChecker;

class NamedValue extends Value
{
    private $name;

    public function __construct($name, $value)
    {
        parent::__construct($value);

        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
