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
            <li>Разобраться с принципом работы PHPUnit.</li>
            <li>По образу и подобию модуля товаров из движка V1.0 создать модуль просмотра карточки товара:
                <ol style="list-style-type:lower-latin;padding-left:20px;margin:10px 0">
                    <li>Карточка должна содержать в себе информацию о товаре, картинки, цену.</li>
                    <li>Должна быть кнопка «Купить» (пока заглушка).</li>
                    <li>Код должен быть покрыт тестами.</li>
                </ol>
            </li>
            <li>*Создать модуль просмотра результатов тестов.</li>
        </ol>
        <?php
        $vars['description'] = ob_get_clean();

        $template = 'common/home.html.twig';

        $this->view->display($template, $vars);
    }
}
