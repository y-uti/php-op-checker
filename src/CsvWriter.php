<?php
namespace YUti\OpChecker;

class CsvWriter implements Writer
{
    public function __construct()
    {
    }

    public function write(Operator $operator, array $parameters, Value $result)
    {
        $row = array();
        $row[] = $operator->getSymbol();
        array_walk(
            $parameters,
            function ($p) use (&$row) {
                $row[] = $p->getType();
                $row[] = $p->getName();
            });
        $row[] = $result->getType();
        $row[] = $result();

        fputcsv(STDOUT, $row);
    }
}
