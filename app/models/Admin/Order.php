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

    public function getTotalProducts()
    {
        $total = 0;

        $sql = "SELECT COUNT(*) as total FROM product";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $total = $query->row['total'];
        }

        return $total;
    }
}