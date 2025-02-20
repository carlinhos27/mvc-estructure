<?php

define('APP_PATH', realpath(dirname(__FILE__)));

class Controller {

    // Cargar el modelo de manera segura
    public function loadModel($model) {
        $modelPath = APP_PATH . "/../models/$model.php"; // Ruta absoluta al modelo
        if (file_exists($modelPath)) {
            require_once $modelPath; // Incluye el modelo
            return new $model(); // Retorna una instancia del modelo
        } else {
            throw new Exception("Model '$model' not found.");
        }
    }

    // Renderizar la vista con los datos proporcionados
    public function renderView($view, $data = []) {
        $viewPath = APP_PATH . "/../views/$view.php"; // Ruta absoluta a la vista
        if (file_exists($viewPath)) {
            // Asignar los datos explícitamente a las variables
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $$key = $value;  // Asigna las variables con el nombre de la clave
                }
            }
            require_once $viewPath; // Incluye la vista
        } else {
            throw new Exception("View '$view' not found.");
        }
    }
}
