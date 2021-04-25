<?php

namespace app\models\Admin;

use app\core\Model;

class Catalog extends Model
{
    public function getProducts($data = [])
    {
        $products = [];

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

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $products = $query->rows;
        }

        return $products;
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