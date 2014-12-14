<?php
namespace YUti\OpChecker;

class ArrayUtil
{
    public static function cartesianProduct(array $arrays)
    {
        if ($arrays) {
            return self::cartesianProduct_rec($arrays);
        } else {
            return new \EmptyIterator();
        }
    }

    private static function cartesianProduct_rec(array $arrays)
    {
        if (!$arrays) {
            yield array();
        } else {
            $tail = array_pop($arrays);
            foreach (self::cartesianProduct_rec($arrays) as $values) {
                foreach ($tail as $v) {
                    yield array_merge($values, array($v));
                }
            }
        }
    }
}
