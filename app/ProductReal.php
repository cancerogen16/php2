<?php

namespace app;

/* штучный физический товар */

class ProductReal extends ProductAbstract {
    public $name;
    public $quantity;

    public function __construct($name, $price, $quantity) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getFinalPrice() {
        return $this->price * (1 + $this->markup / 100);
    }

    public function getTotal() {
        return $this->getFinalPrice() * $this->quantity;
    }

    public function getProfit() {
        return $this->price * $this->markup / 100 * $this->quantity;
    }
}