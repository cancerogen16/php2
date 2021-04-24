<?php

namespace app\core;

use app\models\User;
use app\models\Viewed;

abstract class Controller
{

    public $route;
    public $view;
    public $acl;

    public $user;

    public function __construct($route)
    {
        $this->route = $route;

        $this->user = new User();

        $this->view = new View($route);

        if (!$this->checkAcl()) {
            $vars = [];

            $template = 'errors/403.html.twig';

            $this->view->display($template, $vars);
        }

        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel($name)
    {
        $path = 'app\models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        } else {
            return false;
        }
    }

    public function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }

    public function checkAcl()
    {
        $this->acl = require 'app/acl/' . $this->route['controller'] . '.php';
        if ($this->isAcl('all')) {
            return true;
        } elseif (isset($_SESSION['loggedin']) and $this->isAcl('authorize')) {
            return true;
        } elseif (!isset($_SESSION['loggedin']) and $this->isAcl('guest')) {
            return true;
        } elseif (isset($_SESSION['admin']) and $this->isAcl('admin')) {
            return true;
        }
        return false;
    }

    public function isAcl($key)
    {
        return in_array($this->route['action'], $this->acl[$key]);
    }

    protected function getChild($child, $action)
    {
        $result = '';

        $path = 'app\controllers\\' . ucfirst($child) . 'Controller';

        if (class_exists($path)) {
            if ($action == '') {
                $action = 'index';
            }

            if (method_exists($path, $action)) {
                $controller = new $path($this->route);

                $result = $controller->$action();
            }
        }

        return $result;
    }
}