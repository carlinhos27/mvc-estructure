<?php
class AuthController extends Controller
{

    public function register()
    {
        view('register');
    }

    public function registerPost() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtén los datos del formulario
            $empresaData = [
                'nombre' => $_POST['empresa_nombre'],
                'email' => $_POST['empresa_email'],
                'telefono' => $_POST['empresa_telefono'],
                'direccion' => $_POST['empresa_direccion']
            ];
            
            $userData = [
                'name' => $_POST['usuario_nombre'],
                'email' => $_POST['usuario_email'],
                'password' => password_hash($_POST['usuario_password'], PASSWORD_DEFAULT), // Encriptación de la contraseña
                'role' => $_POST['usuario_role'],
            ];

            // Crear la empresa
            $empresa = new Empresa();
            $empresaId = $empresa->insert($empresaData); // Esto retorna el ID de la empresa recién insertada

            if ($empresaId) {
                // Asignamos el ID de la empresa al nuevo usuario
                $userData['empresa_id'] = $empresaId;

                // Crear el usuario
                $user = new User();
                $userId = $user->insert($userData); // Inserta el usuario

                // Si todo fue exitoso, redirigir a la página de éxito o login
                if ($userId) {
                    header("Location: /");
                } else {
                    echo "Hubo un error al registrar el usuario.";
                }
            } else {
                echo "Hubo un error al registrar la empresa.";
            }
        }
    }

    public function loginForm()
    {
        view('login');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $result = Auth::login($email, $password);

            if ($result === true) {
                header("Location: /dashboard");
                exit;
            } else {
                $_SESSION['error'] = $result;
                header("Location: /login");
                exit;
            }
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}
