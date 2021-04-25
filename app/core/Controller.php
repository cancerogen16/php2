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
            $this->redirect('error/403');
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
        $parts = explode('/', $this->route['controller']);

        $route = '';

        foreach ($parts as $part) {
            $route .= DS . $part;
        }

        $this->acl = require dirname(__DIR__) . DS .'acl' . $route . '.php';

        if ($this->isAcl('all')) {
            return true;
        } elseif (isset($_SESSION['loggedin']) and $this->isAcl('authorize')) {
            return true;
        } elseif (!isset($_SESSION['loggedin']) and $this->isAcl('guest')) {
            return true;
        } elseif (isset($_SESSION['user_role']) and ($_SESSION['user_role'] == 'admin') and $this->isAcl('admin')) {
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

        $parts = explode('/', $child);

        $controllerName = '';

        foreach ($parts as $part) {
            $controllerName .= DS . ucfirst($part);
        }

        $path = 'app\controllers' . $controllerName . 'Controller';

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