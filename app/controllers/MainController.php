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

        $vars['header'] = $this->getChild('CommonHeader', '');

        ob_start();
        ?>
        <ol>
            <li>Разобраться с доработками движка.</li>
            <li>Создать модуль управления заказами:
                <ol>
                    <li>Модуль должен выводить все заказы в обратном хронологическом порядке;</li>
                    <li>Модуль должен уметь менять статус в асинхронном режиме;</li>
                    <li>Код должен быть покрыт тестами.</li>
                </ol>
            </li>
            <li>*Создать функционал отслеживания ролей пользователей и доступа разных ролей к разным блокам.</li>
        </ol>
        <?php
        $vars['description'] = ob_get_clean();

        $template = 'common/home.html.twig';

        $this->view->display($template, $vars);
    }
}
