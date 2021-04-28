<?php

namespace app\models;

use app\core\Model;

class Order extends Model
{
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
}