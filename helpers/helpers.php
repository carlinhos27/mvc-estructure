<?php
function view($path, $data = [])
{
    extract($data);

    $viewPath = __DIR__ . "/../system/auth/views/{$path}.php";

    if (!file_exists($viewPath)) {

        $viewPath = __DIR__ . "/../app/views/{$path}.php";
    }

    if (file_exists($viewPath)) {
        include $viewPath;
    } else {
        die("Error: La vista '{$path}' no existe.");
    }
}

function hashPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}
