<?php
define('DS', DIRECTORY_SEPARATOR); // разделитель для путей к файлам
$sitePath = realpath(dirname(__FILE__)) . DS;
define('SITE_PATH', $sitePath); // путь к корневой папке сайта
define('ASSETS_DIR', SITE_PATH . 'assets' . DS);
define('ADMIN_DIR', SITE_PATH . 'public' . DS . 'admin' . DS);
define('ENGINE_DIR', SITE_PATH . 'engine' . DS);
define('HELPER_DIR', SITE_PATH . 'helper' . DS);
define('VENDOR_DIR', SITE_PATH . 'vendor' . DS);
define('UPLOADS_DIR', SITE_PATH . 'uploads' . DS);
define('TEMPLATES_DIR', SITE_PATH . 'view' . DS);
define('IMAGES_DIR', ASSETS_DIR . 'img' . DS);

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOST', 'localhost');
define('DB_USER', 'geekbrains');
define('DB_PASS', '123456');
define('DB_NAME', 'shop');

require_once VENDOR_DIR . 'autoload.php';