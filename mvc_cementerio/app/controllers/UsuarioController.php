<?php
//Llama al Modelo
require_once(APP . "/models/UsuarioModel.php");

class UsuarioController{
    private $usuario;
    function __contruct(){
        $this->usuario = new UsuarioModel();
    }

    function mostrar(){
        $obj = new UsuarioModel();
        $datos = $obj->getAllUsuarios();
        var_dump($datos);
        require_once("../views/usuarios/UsuarioView.php");
        
    }
}

//Llama a la vista
//require_once("views/UsuarioView.html");
?>
 
