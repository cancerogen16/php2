<?php

namespace app\controllers;

use app\core\Controller;

class CommonController extends Controller
{
    public function headerAction()
    {
        $logged = false;

        $username = '';

        if (!empty($_SESSION["username"])) {
            $logged = true;
            $username = htmlspecialchars($_SESSION["username"]);
        }

        $vars = [
            'logged' => $logged,
            'username' => $username,
        ];

        $template = 'common/header.html.twig';

        return $this->view->render($template, $vars);
    }

    public function footerAction()
    {
        $vars = [
            'title' => 'footerAction',
        ];

        $template = 'common/footer.html.twig';

        return $this->view->render($template, $vars);
    }
}