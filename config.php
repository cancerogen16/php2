<?php
define('DS', DIRECTORY_SEPARATOR); // разделитель для путей к файлам
$sitePath = realpath(dirname(__FILE__) . DS);
define('SITE_PATH', $sitePath); // путь к корневой папке сайта
define('PUBLIC_DIR', SITE_PATH . '/public/');
define('ADMIN_DIR', SITE_PATH . '/public/admin/');
define('ENGINE_DIR', SITE_PATH . '/engine/');
define('VENDOR_DIR', SITE_PATH . '/vendor/');
define('UPLOADS_DIR', SITE_PATH . '/uploads/');
define('LAYOUTS_DIR', SITE_PATH . '/layouts/');
define('TEMPLATES_DIR', SITE_PATH . '/templates/');
define('BLOCKS_DIR', SITE_PATH . '/blocks/');
define('IMAGES_DIR', PUBLIC_DIR . '/img/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOST', 'localhost');
define('DB_USER', 'geekbrains');
define('DB_PASS', '123456');
define('DB_NAME', 'shop');

require_once VENDOR_DIR . 'autoload.php';