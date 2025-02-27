<?php
class HomeController extends Controller
{
    public function index()
    {
        if (!$this->session->has('user_id')) {
            header('Location: /login');
            exit;
        }
        $title = "Inicio";
        $empresaid = $this->session->get('empresa_id');

        $empresaModel = new Empresa();
        $empresa = $empresaModel->find($empresaid);

        ob_start();
        view('home/index', compact("empresa"));
        $content = ob_get_clean();

        view('layouts/layout', compact('title', 'content', 'empresa'));
    }
}
