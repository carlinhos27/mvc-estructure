<?php

function view($path, $data = []) {
    extract($data); // Convierte el array en variables
    $viewPath = __DIR__ . "/../app/views/{$path}.php";

    if (file_exists($viewPath)) {
        include $viewPath;
    } else {
        die("❌ Error: La vista '{$path}' no existe.");
    }
}
