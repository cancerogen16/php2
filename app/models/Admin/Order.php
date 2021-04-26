<?php

namespace app\models\Admin;

use app\core\Model;

class Order extends Model
{
    public function getOrders($data = [])
    {
        $orders = [];

        $sql = "SELECT *, os.name as order_status FROM `order` LEFT JOIN order_status os on `order`.order_status_id = os.order_status_id ORDER BY order_id DESC ";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if (isset($data['limit'])) {
                if ($data['limit'] < 1) {
                    $data['limit'] = 25;
                }
            } else {
                $data['limit'] = 25;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $orders_query = $this->db->query($sql);

        if ($orders_query->num_rows) {
            foreach ($orders_query->rows as $order) {
                $orders[] = $order;
            }
        }

        return $orders;
    }

    public function getOrder($order_id = 0)
    {
        $order_data = [];

        $sql = "SELECT *, os.name as order_status FROM `order` LEFT JOIN order_status os on `order`.order_status_id = os.order_status_id  WHERE order_id = '" . (int)$order_id . "'";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $order_data = $query->row;
        }

        return $order_data;
    }

    public function editOrder($order_id, $data) {
        $sql = "UPDATE `order` SET username = '" . $this->db->escape($data['username']) . "', phone = '" . $this->db->escape($data['phone']) . "', address = '" . $this->db->escape($data['address']) . "', order_status_id = '" . (int)($data['order_status_id']) . "' WHERE order_id = '" . (int)$order_id . "'";
        $this->db->query($sql);

        $sql = "DELETE FROM `order_item` WHERE order_id = '" . (int)$order_id . "'";
        $this->db->query($sql);

        if (!empty($data['order_product'])) {
            $total = 0;

            foreach ($data['order_product'] as $product) {
                $product_total = floatval($product['price']) * intval($product['quantity']);
                $total += $product_total;

                $sql = "INSERT INTO `order_item` (order_id, product_id, name, quantity, price, total) VALUES ('" . (int)$order_id . "', '" . (int)$product['product_id'] . "', '" . $this->db->escape($product['name']) . "', '" . intval($product['quantity']) . "', '" . floatval($product['price']) . "', '" . $product_total . "')";

                $this->db->query($sql);
            }

            $sql = "UPDATE `order` SET total = '" . (float)$total . "' WHERE order_id = '" . (int)$order_id . "'";
            $this->db->query($sql);
        }
    }

    public function getOrderProducts($order_id) {
        $sql = "SELECT * FROM `order_item` WHERE order_id = '" . (int)$order_id . "'";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getOrderStatuses()
    {
        $sql = "SELECT * FROM `order_status`";

        $query = $this->db->query($sql);

        return $query->rows;
    }
}