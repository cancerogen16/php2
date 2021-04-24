<?php

namespace app\controllers;

use app\core\Controller;

class CommonHeaderController extends Controller
{
    public function headerAction()
    {
        $logged = false;

        $username = '';
        $user_id = 0;

        if (!empty($_SESSION["username"])) {
            $logged = true;
            $username = htmlspecialchars($_SESSION["username"]);
            $user_id = (int)$_SESSION["user_id"];
        }

        $vars = [
            'logged' => $logged,
            'username' => $username,
            'user_id' => $user_id,
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