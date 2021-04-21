<?php

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller
{

    public function indexAction()
    {
        $vars = [
            'title' => 'Главная страница',
        ];

        $template = 'common/home.html.twig';

        $this->view->render($template, $vars);
    }
}