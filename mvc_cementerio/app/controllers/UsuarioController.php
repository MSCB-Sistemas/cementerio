<?php
class UsuarioController extends Control{
    private UsuarioModel $model;
    private TiposUsuariosModel $tipoUsuariosModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->model = $this->loadModel("UsuarioModel");
        $this->tipoUsuariosModel = $this->loadModel("TiposUsuariosModel");
    }

    public function index()
    {
        $usuarios = $this->model->getAllUsuarios();

        $datos = [
            'title' => 'Lista de Usuarios',
            'urlCrear' => URL . 'usuario/create',
            'columnas' => ['ID', 'Usuario', 'Nombre', 'Apellido', 'Cargo', 'Sector', 'Telefono', 'Email', 'Rol', 'Activo'],
            'columnas_claves' => ['id_usuario', 'usuario', 'nombre', 'apellido', 'cargo', 'sector', 'telefono', 'email', 'descripcion', 'activo'],
            'data' => $usuarios,
            'acciones' => function ($fila) {
                $id = $fila['id_usuario'];
                $url = URL . 'usuario';
                return '
                    <a href="' . $url . '/edit/' . $id . '" class="btn btn-sm btn-primary">Editar</a>
                    <a href="' . $url . '/delete/' . $id . '" class="btn btn-sm btn-danger">Eliminar</a>
                    <a href="' . $url . '/activate/' . $id . '" class="btn btn-sm btn-success" onclick="return confirm(\'¿Activar este usuario?\');">Activar</a>
                    <a href="' . $url . '/changePass/' . $id . '" class="btn btn-sm btn-warning">Cambiar clave</a>
                ';
            },
            'errores' => [],
        ];

        $this->loadView('partials/tablaAbm', $datos);
    }

    public function create()
    {
        $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();
        $datos = [
            'title' => 'Crear usuario',
            'action' => URL . 'usuario/save',
            'values' => [],
            'errores' => [],
            'tipos' => $tipos,
            'update' => false
        ];

        $this->loadView('usuarios/UsuarioForm', $datos);
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = trim($_POST["usuario"] ?? '');
            $nombre = trim($_POST["nombre"] ?? '');
            $apellido = trim($_POST["apellido"] ?? '');
            $cargo = trim($_POST["cargo"] ?? '');
            $sector = trim($_POST["sector"] ?? '');
            $telefono = trim($_POST["telefono"] ?? '');
            $email = trim($_POST["email"] ?? '');
            $contrasenia = trim($_POST["password"] ?? '');
            $tipoUsuario = $_POST["tipo_usuario"] ?? '';
            $errores = [];

            if (empty($usuario))
                $errores[] = "El usuario es obligatorio.";
            if (empty($nombre))
                $errores[] = "El nombre es obligatorio.";
            if (empty($apellido))
                $errores[] = "El apellido es obligatorio.";
            if (empty($contrasenia))
                $errores[] = "El nombre es obligatorio.";
            if (empty($tipoUsuario))
                $errores[] = "Debe seleccionar un tipo de usuario.";

            if (!empty($errores)) {
                $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();
                $this->loadView('usuarios/UsuarioForm', [
                    'title' => 'Crear nuevo usuario',
                    'action' => URL . 'usuario/save',
                    'values' => $_POST,
                    'errores' => $errores,
                    'tipos' => $tipos,
                    'update' => false
                ]);
                return;
            }
            $contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);

            if ($this->model->insertUsuario($usuario, $nombre, $apellido, $cargo, $sector, $telefono, $email,  $contrasenia, $tipoUsuario)) {
                header("Location: " . URL . "usuario");
                exit;
            } else {
                die("Error al guardar el usuario");
            }
        }
    }

    public function edit($id)
    {
        $usuario = $this->model->getUsuarioId($id);
        $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();

        if (!$usuario) {
            die("Usuario no encontrado");
        }

        $this->loadView("usuarios/UsuarioForm", [
            'title' => "Editar usuario",
            'action' => URL . 'usuario/update/' . $id,
            'values' => [
                'usuario' => $usuario['usuario'],
                'nombre' => $usuario['nombre'],
                'apellido' => $usuario['apellido'],
                'cargo' => $usuario['cargo'],
                'sector' => $usuario['sector'],
                'telefono' => $usuario['telefono'],
                'email' => $usuario['email'],
                'id_tipo_usuario' => $usuario['id_tipo_usuario'],
            ],
            'errores' => [],
            'tipos' => $tipos,
            'update' => true
        ]);
    }

    public function update($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = trim($_POST["usuario"] ?? '');
            $nombre = trim($_POST["nombre"] ?? '');
            $apellido = trim($_POST["apellido"] ?? '');
            $cargo = trim($_POST["cargo"] ?? '');
            $telefono = trim($_POST["telefono"] ?? '');
            $email = trim($_POST["email"] ?? '');
            $sector = trim($_POST["sector"] ?? '');
            $tipoUsuario = $_POST["tipo_usuario"] ?? '';

            $errores = [];
            if (empty($usuario))
                $errores[] = "El usuario es obligatorio.";
            if (empty($nombre))
                $errores[] = "El nombre es obligatorio.";
            if (empty($apellido))
                $errores[] = "El apellido es obligatorio.";
            if (empty($tipoUsuario))
                $errores[] = "Debe seleccionar un tipo de usuario.";

            if (!empty($errores)) {
                $usuario = [
                    'id_usuario' => $id,
                    'usuario' => $usuario,
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'cargo' => $cargo,
                    'telefono'=> $telefono,
                    'email'=> $email,                    
                    'sector' => $sector,
                    'id_tipo_usuario' => $tipoUsuario
                ];
                $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();
                $this->loadView('usuario/UsuarioForm', [
                    'title' => 'Editar usuario',
                    'action' => URL . 'usuario/update/' . $id,
                    'values' => $usuario,
                    'errores' => $errores,
                    'tipos' => $tipos,
                    'update' => true
                ]);
                return;
            }

            if ($this->model->updateUsuario($id, $usuario, $nombre, $apellido, $cargo, $sector, $telefono, $email, $tipoUsuario)) {
                header("Location: " . URL . "usuario");
                exit;
            } else {
                die("Error al actualizar el usuario");
            }
        }
    }

    public function delete($id)
    {
        if ($this->model->deleteUsuario($id)) {
            header("Location: " . URL . "usuario");
            exit;
        } else {
            die("No se pudo eliminar al usuario.");
        }
    }

    public function activate($id)
    {
        if ($this->model->activateUsuario($id)) {
            header("Location: " . URL . "usuario");
            exit;
        } else {
            die("No se pudo activar al usuario");
        }
    }

    public function changePass($id)
    {
        $this->loadView('usuarios/UsuarioFormPass', [
            'title' => 'Cambiar clave',
            'action' => URL . 'usuario/savePass/' . $id,
            'errores' => []
        ]);
    }

    public function savePass($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = trim($_POST["password"]);

            $errores = [];
            if (empty($password)) $errores[] = "El campo nueva contrasenia es obligatorio.";

            if (!empty($errores)) {
                $this->loadView("usuarios/UsuarioFormPass", [
                    'title' => 'Cambiar clave',
                    'action' => URL . 'usuario/savePass/' . $id,
                    'errores' => $errores
                ]);
                return;
            }

            $password = password_hash($password, PASSWORD_DEFAULT);
            if ($this->model->updatePassword($id, $password)) {
                header('Location: ' . URL . 'usuario');
                exit;
            } else {
                die("Error al cambiar la clave");
            }
        }
    }
}
?>
 