<?php

namespace app\models;

use app\core\Model;

class Cart extends Model
{
    public function getCart($user_id)
    {
        $cart = [];

        if ($user_id) {
            $sql = "SELECT * FROM cart WHERE user_id = '" . (int)$user_id . "'";
        } else {
            $sql = "SELECT * FROM cart WHERE session_id = '" . session_id() . "'";
        }

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $cart = $query->row;

            $count = 0;
            $total = 0;

            $products = json_decode($cart['products'], true);

            $cart['products'] = [];

            $image_product_width = 50;
            $image_product_height = 50;

            require_once DIR_HELPERS . 'tools.php';

            $productModel = new Product;

            foreach ($products as $product_id => $quantity) {
                $product = $productModel->getProduct($product_id);

                $total += $quantity * $product['price'];

                if ($product['image']) {
                    $image = resize($product['image'], $image_product_width, $image_product_height);
                } else {
                    $image = resize('noimage.jpg', $image_product_width, $image_product_height);
                }

                $product['thumb'] = $image;

                $product['quantity'] = $quantity;
                $product['total'] = priceFormat((float)$product['price'] * $quantity);
                $product['price'] = priceFormat($product['price']);

                $cart['products'][$product_id] = $product;

                $count++;
            }

            $cart['count'] = $count;
            $cart['total'] = priceFormat($total);
        }

        return $cart;
    }

    public function add($product_id, $quantity, $user_id)
    {

        $date_added = date('Y-m-d H:i:s');

        if ($user_id) {
            $sql = "SELECT * FROM cart WHERE user_id = '" . (int)$user_id . "'";
        } else {
            $sql = "SELECT * FROM cart WHERE session_id = '" . session_id() . "'";
        }

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $cart = $query->row;

            $cart_id = (int)$cart['cart_id'];

            $products = json_decode($cart['products'], true);

            if ($products) {
                if (isset($products[$product_id])) {
                    $products[$product_id] += $quantity;
                } else {
                    $products[$product_id] = $quantity;
                }
            } else {
                $products[$product_id] = $quantity;
            }

            $sql = "UPDATE `cart` SET products = '" . json_encode($products) . "', session_id = '" . session_id() . "', date_added = '" . $date_added . "'  WHERE cart_id = '" . $cart_id . "'";
        } else {
            $products = [$product_id => $quantity];

            $sql = "INSERT INTO `cart` (user_id, products, session_id, date_added) VALUES ('" . (int)$user_id . "', '" . json_encode($products) . "', '" . session_id() . "', '" . $date_added . "')";
        }

        $this->db->query($sql);

        return $this->db->countAffected();
    }
}