<?php

namespace Model;

use Engine\Model_Base;

Class Model_Product Extends Model_Base {
    public function __construct($select = false) {
        parent::__construct($select);
    }

    public function getProducts($select = []) {
        $results = $this->getAllRows();

        return $results;
    }
}