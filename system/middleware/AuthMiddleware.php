<?php

class AuthMiddleware
{
    public static function check()
    {
        $session = new SessionService(); // Usa el servicio de sesión

        $currentUrl = $_SERVER['REQUEST_URI']; // Obtiene la URL actual
        $authRoutes = ['/login', '/register']; // Rutas públicas

        if (!$session->has('user_id') && !in_array($currentUrl, $authRoutes)) {
            // Usuario no autenticado, redirigir a login
            header('Location: /login');
            exit;
        }

        if ($session->has('user_id') && in_array($currentUrl, $authRoutes)) {
            // Usuario autenticado intenta acceder a login/register, redirigir a home
            header('Location: /home');
            exit;
        }
    }
}
