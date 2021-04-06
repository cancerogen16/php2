<?php
/* 4. Наследники класса Product */
class Product {
    public $product_id; // ID товара
    public $name; // Название товара
    public $price; // Цена товара

    /**
     * Получение всех товаров
     */
    public function getProducts() {
    }

    /**
     * Получение товара по его ID
     */
    public function getProduct($product_id) {
    }
}

/* Класс описывает товары типа Книга
*  Отличается новым свойством Количество листов 
*/
class BookProduct extends Product {
    public $length; // Количество листов
}

/* Класс описывает товары типа Автомобиль 
*  Отличается новым свойством Мощность двигателя
*/
class CarProduct extends Product {
    public $power; // Мощность двигателя
}