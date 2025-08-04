<?php
require_once(__DIR__ . "/../models/DeudoModel.php");

class DeudoController {
    private $deudo;

    function __construct() {
        $this->deudo = new DeudoModel();
    }

    function index() {
        $vista = __DIR__ . '/../views/pages/deudos/DeudoView.php';

        require_once(__DIR__ . '/../views/pages/deudos/Header.php');

        if (file_exists($vista)) {
            require $vista;
        } else {
            echo errorMensaje('404', "Vista DeudoView.php no encontrada.");
        }

        require_once(__DIR__ . '/../views/pages/deudos/Footer.php');
    }

    function mostrar() {
        $obj = new DeudoModel();
        $datos = $obj->getAllDeudos();
        var_dump($datos);

        require_once(__DIR__ . '/../views/pages/deudos/Header.php');
        require_once("../views/deudos/DeudoListView.php");
        require_once(__DIR__ . '/../views/pages/deudos/Footer.php');
    }
}
?>