<?php
class Router
{
    private static $instance = null;
    private $routes = [];

    public function __construct()
    {
        if (self::$instance === null) {
            self::$instance = $this;
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    // Métodos para definir rutas con opción de middleware
    public function get($route, $controllerAction, $middleware = null)
    {
        $this->add('GET', $route, $controllerAction, $middleware);
    }

    public function post($route, $controllerAction, $middleware = null)
    {
        $this->add('POST', $route, $controllerAction, $middleware);
    }

    // Añadir rutas con middleware opcional
    private function add($method, $route, $controllerAction, $middleware = null)
    {
        if (is_array($controllerAction) && count($controllerAction) === 2) {
            $this->routes[$method][$route] = [
                'controller' => $controllerAction[0],
                'method' => $controllerAction[1],
                'middleware' => $middleware // Ahora sí pasamos el middleware correctamente
            ];
        }
    }

    public function dispatch()
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        if ($uri === '') {
            $uri = 'home';
        }

        if (isset($this->routes[$method][$uri])) {
            $routeData = $this->routes[$method][$uri];

            // // 🔹 Ejecutar Middleware si está definido
            // if (!empty($routeData['middleware'])) {
            //     $middlewareClass = $routeData['middleware'];
            //     // Cambia la parte de require para que funcione correctamente
            //     require_once __DIR__ . "/../../system/middleware/{$middlewareClass}.php";


            //     if (class_exists($middlewareClass)) {
            //         $middlewareClass::handle();
            //     } else {
            //         die("Middleware '$middlewareClass' no encontrado.");
            //     }
            // }

            $this->callController($routeData);
            return;
        }

        // Verificar rutas con parámetros dinámicos
        foreach ($this->routes[$method] as $route => $controllerAction) {
            $pattern = preg_replace('/\{[\w]+\}/', '([\w-]+)', $route);
            if (preg_match("#^$pattern$#", $uri, $matches)) {
                array_shift($matches);
                $this->callController($controllerAction, $matches);
                return;
            }
        }

        $this->handleNotFound();
    }

    private function callController($controllerAction, $params = [])
{
    $controllerName = $controllerAction['controller'];
    $methodName = $controllerAction['method'];

    // Posibles rutas donde podría estar el controlador
    $controllerPaths = [
        __DIR__ . "/../../app/controllers/{$controllerName}.php",  // app/controllers/
        __DIR__ . "/../auth/{$controllerName}.php" // system/auth/
    ];

    $controllerPath = null;

    // Buscar el controlador en las posibles rutas
    foreach ($controllerPaths as $path) {
        if (file_exists($path)) {
            $controllerPath = $path;
            break;
        }
    }

    // Si el controlador no se encuentra, mostrar error
    if (!$controllerPath) {
        $this->handleNotFound("Controlador '$controllerName' no encontrado.");
    }

    // Incluir el archivo del controlador
    require_once $controllerPath;

    // Asegurar que la clase existe después de incluir el archivo
    if (!class_exists($controllerName)) {
        $this->handleNotFound("Clase '$controllerName' no encontrada.");
    }

    $controller = new $controllerName();

    // Verificar si el método existe en el controlador
    if (!method_exists($controller, $methodName)) {
        $this->handleNotFound("Método '$methodName' no encontrado en '$controllerName'.");
    }

    // Llamar al método del controlador con los parámetros
    call_user_func_array([$controller, $methodName], $params);
}

    private function handleNotFound($message = "Página no encontrada")
    {
        http_response_code(404);
        view('errors/404', ['message' => $message]);
        exit;
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}
