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
            ->put(new Value('null'     , null))
            ->put(new Value('false'    , false))
            ->put(new Value('true'     , true))
            ->put(new Value('0'        , 0))
            ->put(new Value('1'        , 1))
            ->put(new Value('0'        , 0.0))
            ->put(new Value('1'        , 1.0))
            ->put(new Value('empty'    , ''))
            ->put(new Value('0'        , '0'))
            ->put(new Value('1'        , '1'))
            ->put(new Value('abc'      , 'abc'))
            ->put(new Value('empty'    , array()))
            ->put(new Value('non-empty', array(1, 2, 3)))
            ->put(new Value('stdclass' , new \StdClass()))
            ->put(new Value('20140101' , new \DateTime('20140101')))
            ->put(new Value('now'      , new \DateTime()))
            ->put(new Value('stdin'    , STDIN))
            ->put(new Value('stdout'   , STDOUT))
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

    private function applyToValues(Operator $operator, array $values1, array $values2)
    {
        $results = array();
        foreach ($values1 as $n1 => $v1) {
            foreach ($values2 as $n2 => $v2) {
                $result = $operator->applyTo(array($v1->get(), $v2->get()));
                $results[] = array($v1, $v2, new Value('_', $result));
            }
        }

        return $results;
    }

    private function applyToValuesAndDump(Operator $operator, array $values1, array $values2)
    {
        $opSymbol = $operator->getSymbol();
        $results = $this->applyToValues($operator, $values1, $values2);
        foreach ($results as list ($v1, $v2, $result)) {
            $lhs = $v1->type() . '.' . $v1->name();
            $rhs = $v2->type() . '.' . $v2->name();
            echo "$lhs $opSymbol $rhs ; " . $result->get() . "\n";
        }
    }

    public function check(array $argv)
    {
        $values = $this->buildValues();
        $operator = $this->getOperator($argv[1]);

        $types1 = count($argv) > 2 ? array($argv[2]) : TypeUtil::types();
        $types2 = count($argv) > 3 ? array($argv[3]) : TypeUtil::types();
        foreach ($types1 as $t1) {
            foreach ($types2 as $t2) {
                $values1 = $this->getValuesByType($t1);
                $values2 = $this->getValuesByType($t2);
                $this->applyToValuesAndDump($operator, $values1, $values2);
            }
        }
    }
}
