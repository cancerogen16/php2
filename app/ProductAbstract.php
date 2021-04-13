<?php

namespace app;

/* абстрактный товар */

abstract class ProductAbstract {
    protected $name;
    protected $price;
    protected $markup = 20; // Наценка

    abstract protected function getFinalPrice();

    abstract protected function getTotal();

    abstract protected function getProfit();
}