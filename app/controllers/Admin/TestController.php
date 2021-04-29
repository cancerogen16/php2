<?php

namespace app\controllers\Admin;

use app\core\Controller;
use app\lib\JunitParser;

class TestController extends Controller
{
    public function indexAction()
    {
        $vars = [
            'title' => 'Результаты тестов',
        ];

        $vars['header'] = $this->getChild('Admin/CommonHeader', '');

        $junitParser = new JunitParser;

        $vars['output'] = $junitParser->getOutput();

        $template = 'admin/test/index.html.twig';

        $this->view->display($template, $vars);
    }
}