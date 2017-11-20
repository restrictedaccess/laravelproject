<?php
namespace App\Core\Util\Enum;

class Group extends BaseEnum{
       public static function configure() {
        parent::$enums = array();
        $activity = new EnumType("Activity", 10, 1);
        $diet = new EnumType("Diet", 20, 2);
        $lifeStyle = new EnumType("Lifestyle", 30, 3);
        $medicalHealthControl = new EnumType("Medical Health Control", 40, 4);
        $background = new EnumType("Background", 50, 5);
        array_push(parent::$enums, $activity);
        array_push(parent::$enums, $diet);
        array_push(parent::$enums, $lifeStyle);
        array_push(parent::$enums, $medicalHealthControl);
        array_push(parent::$enums, $background);
    }
}
