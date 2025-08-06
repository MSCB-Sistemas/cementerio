<?php
require_once(__DIR__ . "/../models/UsuarioModel.php");

class UsuarioController extends Control{
    private UsuarioModel $model;
    private TiposUsuariosModel $tipoUsuariosModel;

    public function __construct()
    {
        $this->model = $this->loadModel("UsuarioModel");
        $this->tipoUsuariosModel = $this->loadModel("TiposUsuariosModel");
    }

    public function index(){
        $usuarios = $this->model->getAllUsuarios();

        $datos = [
            'title' => 'Lista de Usuarios',
            'urlCrear' => URL . '/usuario/create',
            'columnas' => ['ID', 'Usuario', 'Nombre', 'Apellido', 'Cargo', 'Sector', 'Rol', 'Activo'],
            'columnas_claves' => ['id_usuario', 'usuario', 'nombre', 'apellido', 'cargo', 'sector', 'descripcion', 'activo'],
            'data' => $usuarios,
            'acciones' => function ($fila) {
                $id = $fila['id_usuario'];
                $url = URL .'/usuario';
                return '
                    <a href="' . $url . '/edit/' . $id . '" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="' . $url . '/delete/' . $id . '" class="btn btn-sm btn-outline-primary">Eliminar</a>
                ';
            },
            'errores' => [],
        ];

        $this->loadView('usuarios/UsuarioView', $datos);
    }
    
    public function create() {
        $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();
        $datos = [
            'title'=> 'Crear usuario',
            'action' => URL . '/usuario/save',
            'values' => [],
            'errores' => [],
            'tipos' => $tipos,
            'update' => false
        ];

        $this->loadView('usuarios/UsuarioForm', $datos);
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = trim($_POST['usuario']);
        }
    }
}
?>
 
