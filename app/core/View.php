<?php

namespace app\core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{

    public $path;
    public $route;
    protected $twig;

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];

        $params = [
            'debug' => true
        ];

        $loader = new FilesystemLoader(DIR_TEMPLATES);

        $this->twig = new Environment($loader, $params);
    }

    public function render($template, $vars = [])
    {
        return $this->twig->render($template, $vars);
    }

    public function display($template, $vars = [])
    {
        $this->twig->display($template, $vars);
    }

    public function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }

    public static function errorCode($code)
    {
        http_response_code($code);
        $path = 'app/views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }

    public function message($status, $message)
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }

    public function location($url)
    {
        exit(json_encode(['url' => $url]));
    }

}	