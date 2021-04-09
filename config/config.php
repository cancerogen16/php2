<?php
// DIR
define('basePath', dirname(__DIR__));
define('PUBLIC_DIR', basePath . '/public/');
define('ADMIN_DIR', basePath . '/public/admin/');
define('ENGINE_DIR', basePath . '/engine/');
define('VENDOR_DIR', basePath . '/vendor/');
define('UPLOADS_DIR', basePath . '/uploads/');
define('LAYOUTS_DIR', basePath . '/layouts/');
define('TEMPLATES_DIR', basePath . '/templates/');
define('BLOCKS_DIR', basePath . '/blocks/');
define('IMAGES_DIR', PUBLIC_DIR . '/img/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'geekbrains');
define('DB_PASSWORD', '123456');
define('DB_DATABASE', 'shop');

require_once VENDOR_DIR . 'autoload.php';