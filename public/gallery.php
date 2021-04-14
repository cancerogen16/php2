<?php

namespace App;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/config.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(TEMPLATES_DIR);
$twig = new Environment($loader, ['debug' => true]);

$img = new ImageModel();

$images = $img->getImages();

echo $twig->render('gallery.html.twig', [
    'title' => 'Галерея изображений',
    'name' => 'John Doe',
    'images' => $images
]);