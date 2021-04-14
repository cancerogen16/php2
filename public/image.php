<?php

namespace App;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/config.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(TEMPLATES_DIR);
$twig = new Environment($loader, ['debug' => true]);

$image_id = filter_input(INPUT_GET, 'image_id', FILTER_SANITIZE_SPECIAL_CHARS);

$img = new ImageModel();

$image = $img->getImage($image_id);

echo $twig->render('image.html.twig', [
    'title' => 'Изображение №' . $image_id,
    'name' => 'John Doe',
    'image' => $image
]);