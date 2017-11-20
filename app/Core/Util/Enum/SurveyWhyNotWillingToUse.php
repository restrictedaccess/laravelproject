<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Core\Util\Enum;

/**
 * Description of SurveyWhyNotWillingToUse
 *
 * @author User
 */
class SurveyWhyNotWillingToUse  extends BaseEnum{
       public static function configure() {
        parent::$enums = array();
        array_push(parent::$enums, new EnumType("I'm not worried because I am healthy", "I'm not worried because I am healthy", 1));
        array_push(parent::$enums, new EnumType("I'm more concerned about other diseases (specifically, cancer, stroke, etc.)", "I'm more concerned about other diseases (specifically, cancer, stroke, etc.)", 2));
        array_push(parent::$enums, new EnumType("Economical reasons", "Economical reasons", 3));
        array_push(parent::$enums, new EnumType("live with friends or roommates", "live with friends or roommates", 4));
    }
}
