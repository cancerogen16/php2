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

            $cart['products'] = json_decode($cart['products'], true);
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

    public function delete($cart_id)
    {
        $sql = "DELETE FROM cart WHERE cart_id = '" . (int)$cart_id . "'";

        $this->db->query($sql);

        return $this->db->countAffected();
    }

    public function changeQuantity($product_id, $quantity, $user_id)
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
                    $products[$product_id] = $quantity;
                }
            }

            $sql = "UPDATE `cart` SET products = '" . json_encode($products) . "' WHERE cart_id = '" . $cart_id . "'";

            $this->db->query($sql);
        }

        return $this->db->countAffected();
    }

    public function removeFromCart($product_id, $user_id)
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