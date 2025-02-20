<?php
class Database {
    private static $instance = null;
    private $pdo;

    // Constructor privado para evitar la creación de múltiples instancias
    private function __construct() {
        $config = require "../config/database.php"; // Cargar la configuración

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            $this->pdo = new PDO($dsn, $config['user'], $config['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Mejorar el manejo de errores con más información
            die("Error de conexión: " . $e->getMessage() . " en " . $e->getFile() . " en la línea " . $e->getLine());
        }
    }

    // Obtener la instancia de la conexión
    public static function getConnection() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }

    // Método para cerrar la conexión explícitamente (opcional)
    public function closeConnection() {
        $this->pdo = null;
    }

    // Destructor para asegurar que la conexión se cierra correctamente (opcional)
    public function __destruct() {
        $this->closeConnection();
    }
}
