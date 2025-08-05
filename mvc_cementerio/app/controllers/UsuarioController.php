<?php
//Llama al Modelo
require_once(__DIR__ . "/../models/UsuarioModel.php");

class UsuarioController{
    private $usuario;
    function __construct(){
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

    function login() {
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = $_POST['usuario'] ?? '';
        $contrasenia = $_POST['contrasenia'] ?? '';

        if (empty($usuario) || empty($contrasenia)) {
            $error = "Por favor complete ambos campos.";
        } else {
            $this->usuario = new UsuarioModel();
           // $usuarioEncontrado = $this->usuario->verificarLogin($usuario, $contrasenia);
           $usuarioEncontrado = $this->usuario->verificarLogin($usuario, $contrasenia);

            if ($usuarioEncontrado) {
                $_SESSION['usuario'] = [
                    'nombre' => $usuarioEncontrado['nombre'] ?? $usuarioEncontrado['usuario'],
                    'contrasenia' => $usuarioEncontrado['contrasenia'] ?? 'usuario' 
                ];
                header("Location:" . APP . 'home');
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }
        }

        // Si hay error, volver a mostrar el formulario con mensaje
        $datos['title'] = "Login";
        $datos['error'] = $error;

       header("Location:" .APP);
    } 
}


}

?>
 