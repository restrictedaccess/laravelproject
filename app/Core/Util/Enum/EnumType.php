<?php namespace App\Core\Util\Enum;

class EnumType {

    public $name;
    public $value;
    public $order;

    public function __construct($name, $value, $order) {
        $this->name = $name;
        $this->value = $value;
        $this->order = $order;
    }

}
