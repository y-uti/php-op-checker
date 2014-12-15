<?php
namespace YUti\OpChecker;

class ArrayUtil
{
    public static function cartesianProduct(array $arrays)
    {
        if (!$arrays) {
            yield array();
        } else {
            $tail = array_pop($arrays);
            foreach (self::cartesianProduct($arrays) as $values) {
                foreach ($tail as $v) {
                    yield array_merge($values, array($v));
                }
            }
        }
    }
}
