<?php
namespace YUti\OpChecker;

class TypeUtil
{
    private static $types = array(
        'array'    => 'a',
        'boolean'  => 'b',
        'float'    => 'df',
        'integer'  => 'i',
        'null'     => 'n',
        'object'   => 'o',
        'resource' => 'r',
        'string'   => 's',
    );

    public static function types()
    {
        return array_keys(self::$types);
    }

    public static function normalize($type)
    {
        return self::findByKey(self::getKey($type));
    }

    private static function getKey($type)
    {
        if ($trimmed = trim($type)) {
            return strtolower($trimmed[0]);
        }
        return false;
    }

    private static function findByKey($key)
    {
        foreach (self::$types as $type => $keyChars) {
            if (strpos($keyChars, $key) !== false) {
                return $type;
            }
        }

        return false;
    }
}
