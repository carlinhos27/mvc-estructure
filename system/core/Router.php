<?php
class Router
{
    private static $instance = null;
    private $routes = [];
    private $authRoutes = []; // Rutas exclusivas de autenticación

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

    // Métodos para definir rutas generales
    public function get($route, $controllerAction, $middleware = null)
    {
        $this->add('GET', $route, $controllerAction, $middleware);
    }

    public function post($route, $controllerAction, $middleware = null)
    {
        $this->add('POST', $route, $controllerAction, $middleware);
    }

    // Métodos para definir rutas de autenticación
    public function authGet($route, $controllerAction, $middleware = null)
    {
        $this->addAuth('GET', $route, $controllerAction, $middleware);
    }

    public function authPost($route, $controllerAction, $middleware = null)
    {
        $this->addAuth('POST', $route, $controllerAction, $middleware);
    }

    // Añadir rutas generales con middleware opcional
    private function add($method, $route, $controllerAction, $middleware = null)
    {
        if (is_array($controllerAction) && count($controllerAction) === 2) {
            $this->routes[$method][$route] = [
                'controller' => $controllerAction[0],
                'method' => $controllerAction[1],
                'middleware' => $middleware
            ];
        }
    }

    // Añadir rutas de autenticación con middleware opcional
    private function addAuth($method, $route, $controllerAction, $middleware = null)
    {
        if (is_array($controllerAction) && count($controllerAction) === 2) {
            $this->authRoutes[$method][$route] = [
                'controller' => $controllerAction[0],
                'method' => $controllerAction[1],
                'middleware' => $middleware
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

        // Buscar primero en rutas de autenticación
        if (isset($this->authRoutes[$method][$uri])) {
            $this->callController($this->authRoutes[$method][$uri]);
            return;
        }

        // Luego buscar en rutas generales
        if (isset($this->routes[$method][$uri])) {
            $this->callController($this->routes[$method][$uri]);
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
            __DIR__ . "/../../app/controllers/{$controllerName}.php",
            __DIR__ . "/../auth/{$controllerName}.php"
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

        require_once $controllerPath;

        if (!class_exists($controllerName)) {
            $this->handleNotFound("Clase '$controllerName' no encontrada.");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $methodName)) {
            $this->handleNotFound("Método '$methodName' no encontrado en '$controllerName'.");
        }

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
