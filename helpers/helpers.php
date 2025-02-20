<?php
function view($path, $data = []) {
    extract($data); // Convierte el array en variables

    // Intentar primero en system/auth/views/
    $viewPath = __DIR__ . "/../system/auth/views/{$path}.php";

    if (!file_exists($viewPath)) {
        // Si no existe en esa ruta, intentar en app/views/
        $viewPath = __DIR__ . "/../app/views/{$path}.php";
    }

    if (file_exists($viewPath)) {
        include $viewPath;
    } else {
        die("❌ Error: La vista '{$path}' no existe.");
    }
}
