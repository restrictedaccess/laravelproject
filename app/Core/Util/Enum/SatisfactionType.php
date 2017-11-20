<?php
namespace App\Core\Util\Enum;

/**
 * Description of SatisfactionType
 *
 * @author User
 */
class SatisfactionType extends BaseEnum{
       public static function configure() {
        parent::$enums = array();
        $verySatisfied = new EnumType("Very Satisfied", 1, 1);
        $satisfied = new EnumType("Satisfied", 2, 2);
        $neutral = new EnumType("Neutral", 3, 3);
        $dissatisfied = new EnumType("Dissatisfied", 4, 4);
        $veryDissatisfied = new EnumType("Very dissatisfied", 5, 5);
        $na = new EnumType("N/A (Not Applicable)",6 , 6);
        array_push(parent::$enums, $verySatisfied);
        array_push(parent::$enums, $satisfied);
        array_push(parent::$enums, $neutral);
        array_push(parent::$enums, $dissatisfied);
        array_push(parent::$enums, $veryDissatisfied);
        array_push(parent::$enums, $na);
    }
}
