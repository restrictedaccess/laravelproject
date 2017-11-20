<?php namespace App\Core\Util\Enum;

class BaseEnum {

    protected static $enums = array();

    public  static function configure(){}

    public static function getNames() {
        return self::getOrderedNames();
    }

    public static function getOrderedNames($order = 'ASC') {
        self::populateEnums();
        $orderedEnums = self::$enums;

        if ($order == 'ASC') {
            usort($orderedEnums, array(self::class, "cmpASC"));
        } else {
            usort($orderedEnums, array(self::class, "cmpDESC"));
        }

        $names = array();
        foreach ($orderedEnums as $e) {
            array_push($names, $e->name);
        }
        return $names;
    }

    public static function getEnums() {
        return self::getOrderedEnums();
    }

    public static function getOrderedEnums($order = 'ASC') {
        self::populateEnums();
        $orderedEnums = self::$enums;

        if ($order == 'ASC') {
            usort($orderedEnums, array(self::class, "cmpASC"));
        } else {
            usort($orderedEnums, array(self::class, "cmpDESC"));
        }

        return $orderedEnums;
    }

    public static function getValue($name) {
        self::populateEnums();
        foreach (self::$enums as $e) {
            if ($e->name == $name) {
                return $e->value;
            }
        }
        return null;
    }

    public static function getName($value) {
        self::populateEnums();
        foreach (self::$enums as $e) {
            if ($e->value == $value) {
                return $e->name;
            }
        }
        return null;
    }

    private static function cmpASC($a, $b) {
        return strcmp($a->order, $b->order);
    }

    private static function cmpDESC($a, $b) {
        return -strcmp($a->order, $b->order);
    }

    private static function populateEnums() {
        $calledClass = get_called_class();
        $calledClass::configure();
    }

}

