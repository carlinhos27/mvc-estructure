<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../helpers/helpers.php';
require_once '../system/middleware/AuthMiddleware.php';


function autoloadPaths($class) {
    $paths = [
        '../system/core/',
        '../system/services/',
        '../app/controllers/',
        '../app/models/',
        '../system/auth/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
}

spl_autoload_register('autoloadPaths');

AuthMiddleware::check();

$router = new Router();

require_once '../routes/web.php';
require_once '../routes/auth.php';

$router->dispatch();
exit; 
