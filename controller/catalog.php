<?php

class Controller_Catalog extends Engine\Controller_Base
{
    public function index() {
        $select = array(
            'where' => "1", // условие
            'order' => 'product_id ASC' // сортируем
        );
        $model = new Model\Model_Product($select); // создаем объект модели
        $products = $model->getAllRows(); // получаем все строки

        $this->render('catalog/catalog.html.twig', [
            'title' => 'Каталог товаров',
            'products' => $products
        ]);
    }
}