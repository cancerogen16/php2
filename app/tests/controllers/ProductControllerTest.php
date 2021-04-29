<?php

namespace controllers;

use app\controllers\ProductController;
use PHPUnit\Framework\TestCase;

class ProductControllerTest extends TestCase
{
    public function testProductAction()
    {
        $response = $this->gbTest->dispatchAction('product','GET',['product_id' => 65]);
        $output = json_decode($response->getOutput(),true);

        $this->assertTrue(isset($output['success']) && isset($output['total']));
        $this->assertRegExp('/HTC Touch HD/', $output['success']);

    }
}
