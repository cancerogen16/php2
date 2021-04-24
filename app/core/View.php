<?php

namespace app\core;

use app\models\User;
use app\models\Viewed;
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
        $this->addToViewed();

        $this->twig->display($template, $vars);
    }

    public function addToViewed()
    {
        $user = new User;

        $user_id = $user->getUserId();

        if ($user_id) {
            $url = trim($_SERVER['REQUEST_URI'], '/');

            $viewed = new Viewed;

            $viewed->addView($user_id, $url);
        }
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