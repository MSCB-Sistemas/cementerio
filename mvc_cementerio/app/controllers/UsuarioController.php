<?php
require_once(__DIR__ . "/../models/UsuarioModel.php");

class UsuarioController extends Control{
    private $model;

    function __construct(){
        $this->model = new UsuarioModel();
    }

    function index(){
        $usuarios = $this->model->getAllUsuarios();

        $datos = [
            'title' => 'Lista de Usuarios',
            'columnas' => ['ID', 'Usuario', 'Nombre', 'Apellido', 'Cargo', 'Sector', 'Rol', 'Activo'],
            'columnas_claves' => ['id_usuario', 'usuario', 'nombre', 'apellido', 'cargo', 'sector', 'id_tipo_usuario', 'activo'],
            'acciones' => function ($fila) {

            },
            'values' => [],
            'errores' => [],
            'data' => $usuarios
        ];

        $this->loadView('usuarios/UsuarioListView', $datos);
    }

    function show() {

    }
        
}
?>
 
