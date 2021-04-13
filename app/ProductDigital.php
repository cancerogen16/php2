<?php

namespace app;

/* цифровой товар */

class ProductDigital extends ProductAbstract {
    public $name;

    public function __construct($name, $price) {
        $this->name = $name;
        $this->price = $price;
    }

    public function getFinalPrice() {
        return $this->price * (1 + $this->markup / 100);
    }

    public function getTotal() {
        return $this->getFinalPrice();
    }

    public function getProfit() {
        return $this->price * $this->markup / 100;
    }
}