<?php

namespace app\models;

use app\core\Model;

class Order extends Model
{
    public function getOrder($order_id)
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

    public function addOrder($data)
    {
        $date_added = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `order` (username, phone, address, total, order_status_id, date_added) VALUES ('" . $this->db->escape($data['username']) . "', '" . $this->db->escape($data['phone']) . "', '" . $this->db->escape($data['address']) . "', '" . floatval($data['totalSum']) . "',  '" . (int)$data['order_status_id'] . "', '" . $date_added . "')";

        $this->db->query($sql);

        $order_id = $this->db->getLastId();

        if (!empty($data['cart_products'])) {
            foreach ($data['cart_products'] as $product) {
                $sql = "INSERT INTO `order_item` (order_id, product_id, name, quantity, price, total) VALUES ('" . (int)$order_id . "', '" . (int)$product['product_id'] . "', '" . $this->db->escape($product['name']) . "', '" . intval($product['quantity']) . "', '" . floatval($product['priceSum']) . "', '" . floatval($product['totalSum']) . "')";

                $this->db->query($sql);
            }
        }

        return $order_id;
    }

    public function deleteOrder($order_id)
    {
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
                    unset($products[$product_id]);
                }
            }

            $sql = "UPDATE `cart` SET products = '" . json_encode($products) . "' WHERE cart_id = '" . $cart_id . "'";

            $this->db->query($sql);
        }

        return $this->db->countAffected();
    }
}