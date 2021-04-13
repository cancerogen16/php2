<?php

namespace app;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/config.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(TEMPLATES_DIR);
$twig = new Environment($loader);

echo $twig->render('main.twig', [
    'title' => 'Main',
    'name' => 'John Doe',
    'occupation' => 'gardener'
]);