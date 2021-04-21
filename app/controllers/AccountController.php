<?php

namespace app\controllers;

use app\core\Controller;

class AccountController extends Controller
{

    public function loginAction()
    {
        $vars = [
            'title' => 'Авторизация',
        ];

        $template = 'account/login.html.twig';

        $this->view->render($template, $vars);
    }

    public function registerAction()
    {
        $vars = [
            'title' => 'Регистрация',
        ];

        $template = 'account/register.html.twig';

        $this->view->render($template, $vars);
    }

}