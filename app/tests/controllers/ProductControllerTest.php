<?php

namespace controllers;

use app\controllers\ProductController;
use PHPUnit\Framework\TestCase;

class ProductControllerTest extends TestCase
{
    private $route;
    private $product;

    protected function setUp() :void
    {
        $root = getenv('APP_ROOT');
        require_once $root . '/app/config/config.php';
        $routes = require $root . '/app/config/routes.php';

        $_POST['test'] = '1';

        $this->route = $routes['product'];

        $this->product = new ProductController($this->route);
    }

    /**
     * @dataProvider providerTestProductId
     * @param $product_id
     * @param $expected
     */
    public function testProductId($product_id, $expected)
    {
        $_GET['product_id'] = $product_id;

        $vars = $this->product->productAction();

        $this->assertSame($expected, $vars['product']['product_id']);
    }

    public function providerTestProductId()
    {
        return [
            [65, '65'],
            [4, 4],
            [5, 5],
        ];
    }
}
