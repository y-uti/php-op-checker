<?php
namespace YUti\OpChecker;

class Checker
{
    private $operatorRepository;

    public function __construct()
    {
        $this->operatorRepository = OperatorRepository::newInstance();
    }

    private function buildValues()
    {
        $values = array();

        // NULL
        $nullValues = array(
            'null' => null,
        );
        $this->addType('null', $nullValues, $values);

        // bool
        $boolValues = array(
            'false' => false,
            'true' => true,
        );
        $this->addType('bool', $boolValues, $values);

        // int
        $intValues = array(
            '0' => 0,
            '1' => 1,
        );
        $this->addType('int', $intValues, $values);

        // float
        $floatValues = array(
            '0' => 0.0,
            '1' => 1.0,
        );
        $this->addType('float', $floatValues, $values);

        // string
        $stringValues = array(
            'empty' => '',
            '0' => '0',
            '1' => '1',
            'non-numeric' => 'abc',
        );
        $this->addType('string', $stringValues, $values);

        // array
        $arrayValues = array(
            'empty' => array(),
            'non-empty' => array(0),
        );
        $this->addType('array', $arrayValues, $values);

        // object
        $objectValues = array(
            'stdclass' => new \StdClass(),
            'date-20140101' => new \DateTime('20140101'),
            'date-now' => new \DateTime(),
        );
        $this->addType('object', $objectValues, $values);

        // resource
        $resourceValues = array(
            'stdin' => STDIN,
            'stdout' => STDOUT,
        );
        $this->addType('resource', $resourceValues, $values);

        return $values;
    }

    private function addType($key, array $values, &$acc)
    {
        foreach ($values as $k => $v) {
            $acc["$key.$k"] = $v;
        }
    }

    private function compareValues(Operator $operator, array $values1, array $values2)
    {
        $results = array();
        foreach ($values1 as $k1 => $v1) {
            foreach ($values2 as $k2 => $v2) {
                $results["$k1,$k2"] = $operator->applyTo(array($v1, $v2));
            }
        }

        return $results;
    }

    private function compareAndDump(Operator $operator, array $values1, array $values2)
    {
        $opSymbol = $operator->getSymbol();
        $results = $this->compareValues($operator, $values1, $values2);
        foreach ($results as $k => $v) {
            list ($lhs, $rhs) = explode(',', $k);
            echo "$lhs $opSymbol $rhs : $v\n";
        }
    }

    private function getOperator($symbol)
    {
        return $this->operatorRepository->get($symbol);
    }

    public function check(array $argv)
    {
        $values = $this->buildValues();
        $operator = $this->getOperator($argv[1]);

        if (count($argv) == 4) {
            $values1 = array_filter($values, function ($k) use ($argv) { return explode('.', $k)[0] === $argv[2]; }, ARRAY_FILTER_USE_KEY);
            $values2 = array_filter($values, function ($k) use ($argv) { return explode('.', $k)[0] === $argv[3]; }, ARRAY_FILTER_USE_KEY);
            $this->compareAndDump($operator, $values1, $values2);
        } else {
            $this->compareAndDump($operator, $values, $values);
        }
    }
}
