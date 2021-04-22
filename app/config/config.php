<?php

define('DS', DIRECTORY_SEPARATOR); // разделитель для путей к файлам
$sitePath = str_replace('/', DS, $_SERVER['DOCUMENT_ROOT']) . DS;
define('SITE_PATH', $sitePath); // путь к корневой папке сайта
define('DIR_APPLICATION', SITE_PATH . 'app' . DS);
define('DIR_CONFIG', DIR_APPLICATION . 'config' . DS);
define('DIR_HELPERS', DIR_APPLICATION . 'helpers' . DS);
define('DIR_TEMPLATES', DIR_APPLICATION . 'views' . DS);
define('DIR_PUBLIC', SITE_PATH . 'public' . DS);
define('DIR_VENDOR', SITE_PATH . 'vendor' . DS);
define('DIR_IMAGE', DIR_PUBLIC . 'img' . DS);