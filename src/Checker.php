<?php
namespace YUti\OpChecker;

class Checker
{
    private $operatorRepository;
    private $valueRepository;
    private $writer;

    public function __construct()
    {
        $this->operatorRepository = OperatorRepository::newInstance();
        $this->valueRepository = ValueRepository::newInstance();
        $this->writer = new CsvWriter();
    }

    private function buildValues()
    {
        $this->valueRepository
            ->put(new NamedValue( 'null'                 , null                      ))
            ->put(new NamedValue( 'false'                , false                     ))
            ->put(new NamedValue( 'true'                 , true                      ))
            ->put(new NamedValue( '0'                    , 0                         ))
            ->put(new NamedValue( '1'                    , 1                         ))
            ->put(new NamedValue( '2'                    , 2                         ))
            ->put(new NamedValue( '3'                    , 3                         ))
            ->put(new NamedValue( '0.0'                  , 0.0                       ))
            ->put(new NamedValue( '1.0'                  , 1.0                       ))
            ->put(new NamedValue( '2.0'                  , 2.0                       ))
            ->put(new NamedValue( '3.0'                  , 3.0                       ))
            ->put(new NamedValue( '9223372036854775808'  , 9223372036854775808       ))
            ->put(new NamedValue( '-9223372036854775808' , -9223372036854775808      ))
            ->put(new NamedValue( '1e1000'               , 1e1000                    ))
            ->put(new NamedValue( '-1e1000'              , -1e1000                   ))
            ->put(new NamedValue( 'INF'                  , INF                       ))
            ->put(new NamedValue( '-INF'                 , -INF                      ))
            ->put(new NamedValue( 'NAN'                  , NAN                       ))
            ->put(new NamedValue( '""'                   , ''                        ))
            ->put(new NamedValue( '"0"'                  , '0'                       ))
            ->put(new NamedValue( '"1"'                  , '1'                       ))
            ->put(new NamedValue( '"1foo"'               , '1foo'                    ))
            ->put(new NamedValue( '"1.0"'                , '1.0'                     ))
            ->put(new NamedValue( '"0x1"'                , '0x1'                     ))
            ->put(new NamedValue( '"abc"'                , 'abc'                     ))
            ->put(new NamedValue( '9223372036854775808'  , '9223372036854775808'     ))
            ->put(new NamedValue( '-9223372036854775808' , '-9223372036854775808'    ))
            ->put(new NamedValue( '1e1000'               , '1e1000'                  ))
            ->put(new NamedValue( '-1e1000'              , '-1e1000'                 ))
            ->put(new NamedValue( 'INF'                  , 'INF'                     ))
            ->put(new NamedValue( '-INF'                 , '-INF'                    ))
            ->put(new NamedValue( 'NAN'                  , 'NAN'                     ))
            ->put(new NamedValue( '[]'                   , array()                   ))
            ->put(new NamedValue( '[1,2,3]'              , array(1, 2, 3)            ))
            ->put(new NamedValue( '[1,2,4]'              , array(1, 2, 4)            ))
            ->put(new NamedValue( 'StdClass()'           , new \StdClass()           ))
            ->put(new NamedValue( 'DateTime("19700101")' , new \DateTime('19700101') ))
            ->put(new NamedValue( 'DateTime()'           , new \DateTime()           ))
            ->put(new NamedValue( 'STDIN'                , STDIN                     ))
            ->put(new NamedValue( 'STDOUT'               , STDOUT                    ))
            ->put(new NamedValue( 'STDERR'               , STDERR                    ))
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

    private function write($operator, $parameters, $result)
    {
        return $this->writer->write($operator, $parameters, $result);
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
            $this->write($operator, $values, $retval);
        }
    }

    public function check(array $argv)
    {
        $this->buildValues();
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
