<?php
namespace YUti\OpChecker;

class Operator
{
    private $symbol;
    private $function;

    public function __construct($symbol, callable $function)
    {
        $this->symbol = $symbol;
        $this->function = $function;
    }

    public function __invoke(array $operands)
    {
        return call_user_func_array($this->function, $operands);
    }

    public function getSymbol()
    {
        return $this->symbol;
    }

    public function getFunction()
    {
        return $this->function;
    }
}
