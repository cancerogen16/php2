<?php

namespace Model;

use Engine\Model_Base;

Class Model_Product Extends Model_Base {
    public function __construct($select = false) {
        parent::__construct($select);
    }

    public function getProducts() {
        $results = $this->getAllRows();

        return $results;
    }

    public function getTotalProducts() {
        $results = $this->getOneRow();

        return $results['total'];
    }
}