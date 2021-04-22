<?php

namespace app\models;

use app\core\Model;

class Product extends Model
{
    public function getProducts($data = [])
    {
        $sql = "SELECT * FROM product";

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

        return $this->db->all($sql);
    }

    public function getProduct($product_id = 0)
    {
        $sql = "SELECT * FROM product WHERE product_id = $product_id";

        return $this->db->one($sql);
    }

    public function getTotalProducts()
    {
        $sql = "SELECT COUNT(*) as total FROM product";

        return $this->db->one($sql)['total'];
    }
}