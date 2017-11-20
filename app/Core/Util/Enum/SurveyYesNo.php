<?php

namespace App\Core\Util\Enum;


class SurveyYesNo extends BaseEnum{
       public static function configure() {
        parent::$enums = array();
        $yes = new EnumType("Yes", "1", 1);
        $no = new EnumType("No", "0", 2);
        array_push(parent::$enums, $yes);
        array_push(parent::$enums, $no);
    }
}

