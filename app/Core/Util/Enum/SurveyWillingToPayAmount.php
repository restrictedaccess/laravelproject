<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Core\Util\Enum;

/**
 * Description of SurveyWillingToPayAmount
 *
 * @author User
 */
class SurveyWillingToPayAmount extends BaseEnum{
       public static function configure() {
        parent::$enums = array();
        array_push(parent::$enums, new EnumType("less than $10 a month", "less than $10 a month", 1));
        array_push(parent::$enums, new EnumType("$10 to $20 monthly", "$10 to $20 monthly", 2));
        array_push(parent::$enums, new EnumType("$20 to $30 monthly", "$20 to $30 monthly", 3));
        array_push(parent::$enums, new EnumType("$30 to $40 monthly", "$30 to $40 monthly", 4));
        array_push(parent::$enums, new EnumType("$40 or more montly", "$40 or more montly", 5));
    }
}
