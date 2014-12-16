<?php
namespace YUti\OpChecker;

interface Writer
{
    public function write(Operator $operator, array $parameters, Value $result);
}
