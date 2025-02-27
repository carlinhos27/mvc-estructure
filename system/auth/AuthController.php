<?php

// system/auth/AuthController.php

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct(); // Asegurar que Controller inicializa SessionService
    }

    public function showRegisterForm()
    {
        if ($this->session->has('user_id')) {
            header('Location: /home');
            exit;
        }
        view('register');
    }

    public function showLoginForm()
    {
        if ($this->session->has('user_id')) {
            header('Location: /home');
            exit;
        }
        view('login');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $empresaModel = new Empresa();

            // Validar datos
            $empresaData = [
                'nombre' => $_POST['empresa_nombre'] ?? '',
                'email' => $_POST['empresa_email'] ?? '',
                'telefono' => $_POST['empresa_telefono'] ?? '',
                'direccion' => $_POST['empresa_direccion'] ?? '',
                'plan' => $_POST['empresa_plan'] ?? '',
            ];

            if (empty($empresaData['nombre']) || empty($empresaData['email']) || empty($empresaData['telefono'])) {
                return view('register', ['error' => 'Datos de la empresa incompletos']);
            }

            // Insertar empresa
            if (!$empresaModel->insert($empresaData)) {
                return view('register', ['error' => 'Error al registrar la empresa']);
            }

            // Obtener el ID de la empresa
            $idEmpresa = $empresaModel->lastInsertId();

            // Crear usuario
            $pass = hashPassword($_POST['usuario_password']);
            $userData = [
                'name' => $_POST['usuario_nombre'] ?? '',
                'email' => $_POST['usuario_email'] ?? '',
                'password' => $pass,
                'role_id' => 4, // Rol de administrador
                'empresa_id' => $idEmpresa,
            ];

            if (!$userModel->insert($userData)) {
                return view('register', ['error' => 'Error al registrar el usuario']);
            }

            // Redirigir al login
            header('Location: /login');
            exit;
        }

        return view('register', ['error' => 'Hubo un problema al crear el usuario']);
    }


    public function login()
    {
        if ($this->session->has('user_id')) {
            header('Location: /home');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                return view('login', ['error' => 'Email y contraseña son obligatorios']);
            }

            $userModel = new User();
            $user = $userModel->where(['email' => $email]);

            if (!$user || empty($user[0])) {
                return view('login', ['error' => 'Credenciales incorrectas']);
            }

            // Verificar la contraseña
            if (!verifyPassword($password, $user[0]['password'])) {
                return view('login', ['error' => 'Credenciales incorrectas']);
            }

            // Regenerar ID de sesión para mayor seguridad
            session_regenerate_id(true);

            // Guardar sesión
            $this->session->set('user_id', $user[0]['id']);
            $this->session->set('user_name', $user[0]['name']);
            $this->session->set('empresa_id', $user[0]['empresa_id']);

            // Redirigir al dashboard
            header('Location: /home');
            exit;
        }

        return view('login', ['error' => 'Método no permitido']);
    }

    public function logout()
    {
        // Eliminar todas las variables de sesión
        $_SESSION = [];

        // Destruir la sesión
        session_destroy();

        // Redirigir al login
        header('Location: /login');
        exit;
    }
}
