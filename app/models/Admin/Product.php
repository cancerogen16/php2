<?php

namespace app\models\Admin;

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

    public function editProduct($product_id, $data = [])
    {
        $sql = "UPDATE product SET name = '" . $this->db->escape($data['name']) . "', quantity = '" . (int)$data['quantity'] . "', price = '" . (float)$data['price'] . "', image = '" . $this->db->escape($data['image']) . "'  WHERE product_id = '" . (int)$product_id . "'";

        $this->db->query($sql);
    }

    public function editProductImage($product_id, $data = [])
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