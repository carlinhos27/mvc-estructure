<?php

// routes/auth.php
$router->get('register', ['AuthController', 'showRegisterForm']);
$router->post('register', ['AuthController', 'register']);
$router->get('login', ['AuthController', 'showLoginForm']);
$router->post('login', ['AuthController', 'login']);
$router->get('logout', ['AuthController', 'logout']);
