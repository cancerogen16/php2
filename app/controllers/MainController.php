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

        $header = new CommonController([
            'controller' => 'common',
            'action' => 'header',
        ]);

        $vars['header'] = $header->headerAction();

        ob_start();
        ?>
        <ol>
            <li>Разобраться с принципом работы движка.</li>
            <li>По образу и подобию модуля авторизации из движка V1.0 создать модуль работы с пользователем:
                <ol>
                    <li>Пользователь должен уметь входить в систему;</li>
                    <li>Пользователь должен уметь выходить из системы;</li>
                    <li>У пользователя должен быть личный кабинет (пока пустой).</li>
                </ol>
            </li>
            <li>*Научить движок запоминать 5 последних просмотренных страниц. Выводить их в личном кабинете блоком «Вы недавно смотрели».</li>
        </ol>
        <?php
        $vars['description'] = ob_get_clean();

        $template = 'common/home.html.twig';

        $this->view->display($template, $vars);
    }
}