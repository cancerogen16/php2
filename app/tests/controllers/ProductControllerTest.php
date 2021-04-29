<?php

namespace app\tests\controllers;

use app\controllers\ProductController;
use PHPUnit\Framework\TestCase;

class ProductControllerTest extends TestCase
{
    private $route;
    private $productFixture;

    protected function setUp() :void
    {
        $root = getenv('APP_ROOT');
        require_once $root . '/app/config/config.php';
        $routes = require $root . '/app/config/routes.php';

        $_POST['test'] = '1';

        $this->route = $routes['product'];

        $this->productFixture = new ProductController($this->route);
    }

    /**
     * @dataProvider providerTestProductId
     * @param $product_id
     * @param $expected
     */
    public function testProductId($product_id, $expected)
    {
        $_GET['product_id'] = $product_id;

        $vars = $this->productFixture->productAction();

        $this->assertSame($expected, $vars['product']['product_id']);
    }

    public function providerTestProductId()
    {
        return [
            [65, '65'],
            [61471, '61471'],
        ];
    }

    /**
     * @dataProvider providerTestProductThumb
     * @param $product_id
     * @param $expected
     */
    public function testProductThumb($product_id, $expected)
    {
        $_GET['product_id'] = $product_id;

        $vars = $this->productFixture->productAction();

        $this->assertSame($expected, $vars['product']['thumb']);
    }

    public function providerTestProductThumb()
    {
        return [
            [65, 'cache/1-500x500.jpg'],
            [0, 'cache/noimage-500x500.jpg'],
            [5, 'cache/noimage-500x500.jpg'],
        ];
    }

    public function testRender()
    {
        $template = 'product/product.html.twig';

        $vars = [];
        $content = "Нет товара в базе данных";
        $this->assertStringContainsString($content, $this->productFixture->view->render($template, $vars), "Содержимое не соответствует");
    }

    protected function tearDown() : void
    {
        $this->productFixture = NULL;
    }

}
