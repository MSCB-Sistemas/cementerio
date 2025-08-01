<?php
//Llama al Modelo
require_once(__DIR__ . "/../models/UsuarioModel.php");

class UsuarioController{
    private $usuario;
    function __contruct(){
        $this->usuario = new UsuarioModel();
    }

    function index(){
        // llevar a pagina de login
        $vista = __DIR__ . '/../views/pages/usuarios/LoginView.php';


         // Cargar header
        require_once(__DIR__ . '/../views/pages/usuarios/Header.php');


        if (file_exists($vista)) {
            require $vista;
        } else {
            echo errorMensaje('404', "Vista loginView.php no encontrada.");
        }

         // Cargar footer
        require_once(__DIR__ . '/../views/pages/usuarios/Footer.php');
    
    }

    function mostrar(){
        $obj = new UsuarioModel();
        $datos = $obj->getAllUsuarios();
        var_dump($datos);

        require_once(__DIR__ . '/../views/pages/usuarios/Header.php');

        
        require_once("../views/usuarios/UsuarioView.php");

         // Cargar footer
        require_once(__DIR__ . '/../views/pages/usuarios/Footer.php');
        
    }
}

?>
 
