<?php

$router->get('home', [HomeController::class, 'index'], 'AuthMiddleware');
$router->get('/', [HomeController::class, 'index'], 'AuthMiddleware');
