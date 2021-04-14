<?php

namespace App;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/config.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(TEMPLATES_DIR);
$twig = new Environment($loader);

echo $twig->render('home.html.twig', [
    'title' => 'Главная',
    'description' => 'Методичка 3. Профессиональная веб-разработка на PHP. Шаблонизаторы'
]);