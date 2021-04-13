<?php

namespace app;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

/* штучный физический товар */
$productReal1 = new ProductReal('Кружка', 330, 15);

/* Цифровой товар */
$productDigital1 = new ProductDigital('PHP7 для начинающих', 1200);

/* товар на вес */
$productWeight1 = new ProductWeight('Горох', 45, 2.5);

echo "Штучный товар - {$productReal1->name}. Продано: {$productReal1->quantity} шт. Финальная стоимость: {$productReal1->getFinalPrice()}. Общая стоимость: {$productReal1->getTotal()}. Прибыль: {$productReal1->getProfit()}<hr>";
echo "Цифровой товар - {$productDigital1->name}. Продано: 1 шт. Финальная стоимость: {$productDigital1->getFinalPrice()}. Общая стоимость: {$productDigital1->getTotal()}. Прибыль: {$productDigital1->getProfit()}<hr>";
echo "Весовой товар - {$productWeight1->name}. Продано: {$productWeight1->weight} кг. Финальная стоимость: {$productWeight1->getFinalPrice()}. Общая стоимость: {$productWeight1->getTotal()}. Прибыль: {$productWeight1->getProfit()}<hr>";

class Test {
    use SingletonTrait;

    public $var;

    public function getVar() {
    }
}

$singleton = Test::getInstance();

try {
    $single = new Test();
} catch (\Throwable $th) {
    echo 'Выброшено исключение: ',  $th->getMessage(), "\n";
}
