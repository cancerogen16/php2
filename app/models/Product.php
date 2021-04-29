<?php

namespace app\models;

use app\core\Model;

class Product extends Model
{
    public function getProduct($product_id = 0)
    {
        $product_data = [];

        $sql = "SELECT * FROM product WHERE product_id = '" . (int)$product_id . "'";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $product_data = $query->row;
        }

        return $product_data;
    }

    /**
     * @param $products
     * @param int $width
     * @param int $height
     * @return array CartData (count, total, products)
     */
    public function getCartData($products, $width = 100, $height = 100)
    {
        $cartProducts = [];

        $count = 0;
        $total = 0;

        if (!empty($products)) {
            require_once DIR_HELPERS . 'tools.php';

            foreach ($products as $product_id => $quantity) {
                $product = $this->getProduct($product_id);

                $total += $quantity * $product['price'];

                $product['thumb'] = getThumb($product['image'], $width, $height);

                $product['quantity'] = $quantity;
                $product['totalSum'] = (float)$product['price'] * $quantity;
                $product['total'] = priceFormat((float)$product['price'] * $quantity);
                $product['priceSum'] = $product['price'];
                $product['price'] = priceFormat($product['price']);

                $cartProducts[] = $product;

                $count++;
            }
        }

        $cartData = [
            'count' => $count,
            'totalSum' => $total,
            'total' => priceFormat($total),
            'products' => $cartProducts,
        ];

        return $cartData;
    }
}