<?php

namespace app\models;

use app\core\Model;

class Common extends Model
{
    public function getNews()
    {
        $result = $this->db->all('SELECT title, description FROM news');
        return $result;
    }
}