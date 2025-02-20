<?php
// Rutas de autenticación
// Ruta para mostrar el formulario de login
$router->authGet('login', [AuthController::class, 'loginForm']);

// Ruta para procesar el login (POST)
$router->authPost('login', [AuthController::class, 'login']);

$router->authGet('register', [AuthController::class, 'register']);
$router->authPost('register', [AuthController::class, 'registerPost']);
