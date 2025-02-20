<?php

class Auth {
    public static function login($email, $password) {
        $userModel = new User();
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        $user = $userModel->where('email', $email);
        
        if (!$user) {
            return "Usuario no encontrado";
        }

        // Verificar contraseña con hash seguro
        if (!password_verify($password, $user['password'])) {
            return "Contraseña incorrecta";
        }

        // Verificar estado del usuario
        if ($user['status'] !== 'activo') {
            return "Cuenta inactiva";
        }

        // Iniciar sesión de forma segura
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['name'];

        return true;
    }

    public static function logout() {
        session_start();
        $_SESSION = [];
        session_destroy();
        header("Location: /login");
        exit;
    }

    public static function user() {
        return isset($_SESSION['user_id']) ? [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'role' => $_SESSION['user_role']
        ] : null;
    }

    public static function check() {
        return isset($_SESSION['user_id']);
    }
}