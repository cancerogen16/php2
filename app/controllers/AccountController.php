<?php

namespace app\controllers;

use app\core\Controller;
use app\models\User;

class AccountController extends Controller
{
    public function loginAction()
    {
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            $this->view->redirect('/');
        }

        $vars = [
            'title' => 'Авторизация',
        ];

        $vars['username'] = $vars['password'] = "";
        $vars['username_err'] = $vars['password_err'] = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty(trim($_POST["username"]))) {
                $vars['username_err'] = "Введите ваш логин";
            } else {
                $vars['username'] = trim($_POST["username"]);
            }

            if (empty(trim($_POST["password"]))) {
                $vars['password_err'] = "Введите ваш пароль";
            } else {
                $vars['password'] = trim($_POST["password"]);
            }

            if (empty($vars['username_err']) && empty($vars['password_err'])) {
                $users = $this->user->getUser($vars['username']);

                if (count($users) == 1) {
                    $user = reset($users);

                    $hashed_password = $user['password'];

                    if (password_verify($vars['password'], $hashed_password)) {
                        $_SESSION["loggedin"] = true;
                        $_SESSION["username"] = $vars['username'];
                        $_SESSION["user_id"] = $user['user_id'];
                        $_SESSION["user_role"] = $user['user_role'];

                        if ($user['user_role'] == 'admin') {
                            header("location: /admin/index.php");
                        } else {
                            header("location: /index.php");
                        }

                        exit();
                    } else {
                        $vars['password_err'] = "Пароль неверный";
                    }
                } else {
                    $vars['username_err'] = "Не найден аккаунт с таким логином";
                }
            }
        }

        $header = new CommonController([
            'controller' => 'common',
            'action' => 'header',
        ]);

        $template = 'common/header.html.twig';

        $vars['header'] = $header->view->render($template, $vars);

        $template = 'account/login.html.twig';

        $this->view->display($template, $vars);
    }

    public function registerAction()
    {
        $vars = [
            'title' => 'Регистрация',
        ];

        $template = 'account/register.html.twig';

        $this->view->display($template, $vars);
    }

}