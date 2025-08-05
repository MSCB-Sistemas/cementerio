<?php

class HomeController {

    public function index() {
        session_start();

        // Verificar si el usuario está logueado
        if (!isset($_SESSION['usuario'])) {
            header("Location: " . APP . 'home');
            exit;
        }

        // Opcional: obtener datos del usuario
        $model = new UsuarioModel();
        $usuario = $model->buscarUsuarios(['email' => $_SESSION['usuario']]);
        $usuario = $usuario[0] ?? null;

        // Cargar vista y pasar datos
        require 'views/homeView.php';
    }
}
