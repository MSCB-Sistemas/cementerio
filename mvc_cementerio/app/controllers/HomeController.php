<?php
//Llama al Modelo
require_once(__DIR__ . '/../app/config/config.php');
require_once(__DIR__ . '/../app/config/errores.php');


class HomeController{
    private $usuario;
    function __construct(){
        $this->usuario = new UsuarioModel();
    }

    function index(){
        // llevar a pagina principal
        $vista = __DIR__ . '/../views/pages/home/HomeView.php';


         // Cargar header
       // require_once(__DIR__ . '/../views/pages/home/Header.php');


        if (file_exists($vista)) {
            require $vista;
        } else {
            echo errorMensaje('404', "Vista loginView.php no encontrada.");
        }

         // Cargar footer
      //  require_once(__DIR__ . '/../views/pages/home/Footer.php');
    
    


   

       
    } 
}




?>
 