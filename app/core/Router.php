<?php

namespace app\core;

class Router
{

    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        $arr = require dirname(__DIR__) . DS . 'config' . DS . 'routes.php';

        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    public function add($route, $params)
    {
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        $parts = parse_url($url);

        if ($parts) {
            foreach ($this->routes as $route => $params) {
                if (preg_match($route, $parts['path'], $matches)) {
                    $this->params = $params;
                    return true;
                }
            }
        }

        return false;
    }

    public function run()
    {
        if ($this->match()) {
            $path = 'app\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($path)) {
                $action = $this->params['action'] . 'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);

                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }
}