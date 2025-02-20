<?php
// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once '../helpers/helpers.php';


// Autoload para cargar clases de `app/core/`, `app/controllers/` y `app/models/`
spl_autoload_register(function ($class) {
    $paths = ['../system/core/', '../app/controllers/', '../app/models/'];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Instanciar el router
$router = new Router();

// Cargar rutas
require_once '../routes/web.php';
require_once '../routes/auth.php';

// Procesar la solicitud
$router->dispatch();
