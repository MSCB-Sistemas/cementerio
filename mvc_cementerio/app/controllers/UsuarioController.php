<?php
require_once(__DIR__ . "/../models/UsuarioModel.php");

class UsuarioController{
    private $usuario;

    function __construct(){
        $this->usuario = new UsuarioModel();
    }

    function index(){
        $vista = __DIR__ . '/../views/pages/usuarios/LoginView.php';

        require_once(__DIR__ . '/../views/pages/usuarios/Header.php');
        if (file_exists($vista)) {
            require $vista;
        } else {
            echo errorMensaje('404', "Vista loginView.php no encontrada.");
        }
        require_once(__DIR__ . '/../views/pages/usuarios/Footer.php');
    }

    function mostrar() {
        $obj = new UsuarioModel();
        $datos = $obj->getAllUsuarios();
        // var_dump($datos);

        $vista = __DIR__ . '/../views/pages/usuarios/UsuarioView.php';
        require_once(__DIR__ . '/../views/pages/usuarios/Header.php');
        if (file_exists($vista)) {
            require $vista;
        } else {
            echo errorMensaje('404', "Vista UsuarioView.php no encontrada.");
        }
        require_once(__DIR__ . '/../views/pages/usuarios/Footer.php');
    }
}

?>
 
