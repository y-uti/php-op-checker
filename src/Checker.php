<?php
namespace YUti\OpChecker;

class Checker
{
    private $operatorRepository;
    private $valueRepository;

    public function __construct()
    {
        $this->operatorRepository = OperatorRepository::newInstance();
        $this->valueRepository = ValueRepository::newInstance();
    }

    private function buildValues()
    {
        $this->valueRepository
            ->put(new NamedValue('null'     , null))
            ->put(new NamedValue('false'    , false))
            ->put(new NamedValue('true'     , true))
            ->put(new NamedValue('0'        , 0))
            ->put(new NamedValue('1'        , 1))
            ->put(new NamedValue('0'        , 0.0))
            ->put(new NamedValue('1'        , 1.0))
            ->put(new NamedValue('empty'    , ''))
            ->put(new NamedValue('0'        , '0'))
            ->put(new NamedValue('1'        , '1'))
            ->put(new NamedValue('abc'      , 'abc'))
            ->put(new NamedValue('empty'    , array()))
            ->put(new NamedValue('non-empty', array(1, 2, 3)))
            ->put(new NamedValue('stdclass' , new \StdClass()))
            ->put(new NamedValue('20140101' , new \DateTime('20140101')))
            ->put(new NamedValue('now'      , new \DateTime()))
            ->put(new NamedValue('stdin'    , STDIN))
            ->put(new NamedValue('stdout'   , STDOUT))
            ;
    }

    private function getOperator($symbol)
    {
        return $this->operatorRepository->get($symbol);
    }

    private function getValuesByType($type)
    {
        return $this->valueRepository->getByType($type);
    }

    private function applyToValues(Operator $operator, array $values)
    {
        $args = array_map(function ($v) { return $v(); }, $values);

        return new Value($operator($args));
    }

    private function applyToTypes(Operator $operator, array $types)
    {
        $setOfValues = array_map(function ($t) { return $this->getValuesByType($t); }, $types);
        foreach (ArrayUtil::cartesianProduct($setOfValues) as $values) {
            $retval = $this->applyToValues($operator, $values);

            $opSymbol = $operator->getSymbol();
            list ($v1, $v2) = $values;
            $lhs = $v1->getType() . '.' . $v1->getName();
            $rhs = $v2->getType() . '.' . $v2->getName();
            echo "$lhs $opSymbol $rhs : " . $retval() . "\n";
        }
    }

    public function check(array $argv)
    {
        $values = $this->buildValues();
        $operator = $this->getOperator($argv[1]);

        $setOfTypes = array();
        for ($i = 2; $i <= 3; ++$i) {
            $setOfTypes[] = count($argv) > $i ? array($argv[$i]) : TypeUtil::types();
        }

        foreach (ArrayUtil::cartesianProduct($setOfTypes) as $types) {
            $this->applyToTypes($operator, $types);
        }
    }
}
