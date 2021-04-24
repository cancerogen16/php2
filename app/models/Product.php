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
}