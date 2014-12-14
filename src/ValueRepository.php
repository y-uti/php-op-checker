<?php
namespace YUti\OpChecker;

class ValueRepository
{
    private $repository;

    private static function initialize(ValueRepository $instance)
    {
        $instance->repository = array_fill_keys(TypeUtil::types(), array());
    }

    public static function newInstance()
    {
        $instance = new ValueRepository();
        self::initialize($instance);

        return $instance;
    }

    private function __construct()
    {
        $this->repository = array();
    }

    public function getByType($type)
    {
        if ($normalized = TypeUtil::normalize($type)) {
            return $this->repository[$normalized];
        }

        return false;
    }

    public function put(NamedValue $value)
    {
        if ($type = $value->getType()) {
            $this->repository[$type][$value->getName()] = $value;
        }

        return $this;
    }
}
