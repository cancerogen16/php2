<?php

namespace app\tests\controllers\Admin;

use app\controllers\Admin\OrderController;
use PHPUnit\Framework\TestCase;

class OrderControllerTest extends TestCase
{
    private $order;

    protected function setUp() : void
    {
        $root = getenv('APP_ROOT');
        require_once $root . '/app/config/config.php';
        $routes = require $root . '/app/config/routes.php';

        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = 'admin';
        $_SESSION["user_role"] = 'admin';

        $_POST['test'] = '1';

        $route = $routes['admin/orders'];

        $this->order = new OrderController($route);
    }

    public function testGetList()
    {
        $ordersList = $this->order->getList();

        $this->assertEquals('Список заказов', $ordersList['title']);
        $this->assertIsArray($ordersList['orders']);
        $this->assertIsArray($ordersList['statuses']);
        $this->assertIsString($ordersList['header']);
    }

    public function testGetForm()
    {
        $_POST['username'] = $_POST['phone'] = $_POST['address'] = '';

        $order_id = 15;
        $_GET['order_id'] = $order_id;

        $orderForm = $this->order->getForm();

        $this->assertEquals($order_id, $orderForm['order_id']);
        $this->assertEquals('Редактирование заказа #' . $order_id, $orderForm['title']);
        $this->assertEquals('/admin/order/edit?order_id=' . $order_id, $orderForm['action']);
        $this->assertIsArray($orderForm['statuses']);
        $this->assertIsString($orderForm['header']);
    }

    public function testValidateForm()
    {
        $_POST['username'] = 'test_user';
        $_POST['phone'] = '12345';
        $_POST['address'] = '';

        $this->assertEquals(false, $this->order->validateForm());
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

}
