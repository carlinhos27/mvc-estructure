<?php
class HomeController extends Controller
{
    public function index()
    {
        $title = "Inicio";
        // Capturar la vista en un buffer para pasarlo al layout
        ob_start();
        view('home/index');
        $content = ob_get_clean();
        // Cargar el layout con la vista renderizada
        view('layouts/layout', compact('title', 'content'));
    }
}
