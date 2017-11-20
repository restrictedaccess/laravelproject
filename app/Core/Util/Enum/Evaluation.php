<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Core\Util\Enum;

/**
 * Description of Evaluation
 *
 * @author User
 */
class Evaluation extends BaseEnum{
      public static function configure() {
        parent::$enums = array();
        $excellent = new EnumType("Excellent", 10, 1);
        $good = new EnumType("Good", 20, 2);
        $average = new EnumType("Average", 30, 3);
        $fair = new EnumType("Fair", 40, 4);
        $poor = new EnumType("Poor", 50, 5);
        array_push(parent::$enums, $excellent);
        array_push(parent::$enums, $good);
        array_push(parent::$enums, $average);
        array_push(parent::$enums, $fair);
        array_push(parent::$enums, $poor);
    }
}
