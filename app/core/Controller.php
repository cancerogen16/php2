<?php

namespace app\core;

use app\models\User;
use app\models\Viewed;

abstract class Controller
{

    /**
     * @var
     */
    public $route;
    /**
     * @var User
     */
    public $user;
    /**
     * @var View
     */
    public $view;
    /**
     * @var bool|mixed
     */
    public $model;

    /**
     * @var
     */
    public $acl;

    /**
     * Controller constructor.
     * @param $route
     */
    public function __construct($route)
    {
        $this->route = $route;

        if (!$this->checkAcl()) {
            $this->redirect('/error/403');
        }

        $this->user = new User();

        $this->view = new View($route);

        $this->model = $this->loadModel($route['controller']);
    }

    /**
     * @param $name
     * @return bool|mixed
     */
    public function loadModel($name)
    {
        $parts = explode('/', $name);

        $modelName = '';

        foreach ($parts as $part) {
            $modelName .= DS . ucfirst($part);
        }

        $path = 'app\models' . $modelName;

        if (class_exists($path)) {
            return new $path;
        } else {
            return false;
        }
    }

    /**
     * @param $url
     */
    public function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }

    /**
     * @return bool
     */
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

    /**
     * @param $key
     * @return bool
     */
    public function isAcl($key)
    {
        return in_array($this->route['action'], $this->acl[$key]);
    }

    /**
     * @param $child
     * @param $action
     * @return string
     */
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