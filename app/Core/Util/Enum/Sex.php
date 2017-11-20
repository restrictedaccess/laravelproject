<?php
namespace App\Core\Util\Enum;
class Sex extends BaseEnum {

    public static function configure() {
        parent::$enums = array();
        $female = new EnumType("Female", 1, 1);
        $male = new EnumType("Male", 2, 2);
        array_push(parent::$enums, $female);
        array_push(parent::$enums, $male);
    }

}
