<?php

namespace app\controllers;

use app\core\Controller;

class ErrorController extends Controller
{
    public function error403Action()
    {
        $vars = [
            'title' => 'Ошибка 403 (Forbidden, доступ запрещен)',
        ];

        $vars['header'] = $this->getChild('CommonHeader', '');

        $template = 'errors/403.html.twig';

        $this->view->display($template, $vars);
    }

    public function error404Action()
    {
        $vars = [
            'title' => 'Ошибка 404 (http status 404)',
        ];

        $vars['header'] = $this->getChild('CommonHeader', '');

        $template = 'errors/404.html.twig';

        $this->view->display($template, $vars);
    }
}
