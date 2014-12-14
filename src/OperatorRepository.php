<?php
namespace YUti\OpChecker;

class OperatorRepository
{
    private $repository;

    private static function setBuiltinOperators(OperatorRepository $repository)
    {
        $repository
            ->put(new Operator('+'  , function ($a, $b) { return $a +   $b; }))
            ->put(new Operator('-'  , function ($a, $b) { return $a -   $b; }))
            ->put(new Operator('*'  , function ($a, $b) { return $a *   $b; }))
            ->put(new Operator('/'  , function ($a, $b) { return $a /   $b; }))
            ->put(new Operator('%'  , function ($a, $b) { return $a %   $b; }))
            ->put(new Operator('**' , function ($a, $b) { return $a **  $b; }))
            ->put(new Operator('&'  , function ($a, $b) { return $a &   $b; }))
            ->put(new Operator('|'  , function ($a, $b) { return $a |   $b; }))
            ->put(new Operator('^'  , function ($a, $b) { return $a ^   $b; }))
            ->put(new Operator('<<' , function ($a, $b) { return $a <<  $b; }))
            ->put(new Operator('>>' , function ($a, $b) { return $a >>  $b; }))
            ->put(new Operator('==' , function ($a, $b) { return $a ==  $b; }))
            ->put(new Operator('===', function ($a, $b) { return $a === $b; }))
            ->put(new Operator('!=' , function ($a, $b) { return $a !=  $b; }))
            ->put(new Operator('<>' , function ($a, $b) { return $a <>  $b; }))
            ->put(new Operator('!==', function ($a, $b) { return $a !== $b; }))
            ->put(new Operator('<'  , function ($a, $b) { return $a <   $b; }))
            ->put(new Operator('>'  , function ($a, $b) { return $a >   $b; }))
            ->put(new Operator('<=' , function ($a, $b) { return $a <=  $b; }))
            ->put(new Operator('>=' , function ($a, $b) { return $a >=  $b; }))
            ->put(new Operator('and', function ($a, $b) { return $a and $b; }))
            ->put(new Operator('or' , function ($a, $b) { return $a or  $b; }))
            ->put(new Operator('xor', function ($a, $b) { return $a xor $b; }))
            ->put(new Operator('&&' , function ($a, $b) { return $a &&  $b; }))
            ->put(new Operator('||' , function ($a, $b) { return $a ||  $b; }))
            ->put(new Operator('.'  , function ($a, $b) { return $a .   $b; }))
            ;
    }

    public static function newInstance($withBuiltinOperators = true)
    {
        $repository = new OperatorRepository();
        if ($withBuiltinOperators) {
            self::setBuiltinOperators($repository);
        }
        return $repository;
    }

    private function __construct()
    {
        $this->repository = array();
    }

    public function get($symbol)
    {
        if (array_key_exists($symbol, $this->repository)) {
            return $this->repository[$symbol];
        } else {
            return false;
        }
    }

    public function put(Operator $operator)
    {
        $this->repository[$operator->getSymbol()] = $operator;
        return $this;
    }
}
