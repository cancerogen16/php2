<?php

namespace app\controllers;

use app\core\Controller;

class CheckoutController extends Controller
{
    public function cartAction()
    {
        $vars = [
            'title' => 'Корзина',
        ];

        $vars['header'] = $this->getChild('CommonHeader', '');

        $vars['description'] = ob_get_clean();

        $template = 'checkout/cart.html.twig';

        $this->view->display($template, $vars);
    }
}
