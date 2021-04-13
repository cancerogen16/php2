<?php

namespace app;

/* товар на вес */

class ProductWeight extends ProductAbstract {
    public $name;
    public $weight;

    public function __construct($name, $price, $weight) {
        $this->name = $name;
        $this->price = $price;
        $this->weight = $weight;
    }

    public function getFinalPrice() {
        return $this->price * (1 + $this->markup / 100);
    }

    public function getTotal() {
        return $this->getFinalPrice() * $this->weight;
    }

    public function getProfit() {
        return $this->price * $this->markup / 100 * $this->weight;
    }
}