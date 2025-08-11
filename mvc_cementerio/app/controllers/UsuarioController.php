<?php
class UsuarioController extends Control{
    private UsuarioModel $model;
    private TiposUsuariosModel $tipoUsuariosModel;

    public function __construct()
    {
        $this->model = $this->loadModel("UsuarioModel");
        $this->tipoUsuariosModel = $this->loadModel("TiposUsuariosModel");
    }

    public function index()
    {
        $usuarios = $this->model->getAllUsuarios();

        $datos = [
            'title' => 'Lista de Usuarios',
            'urlCrear' => URL . '/usuario/create',
            'columnas' => ['ID', 'Usuario', 'Nombre', 'Apellido', 'Cargo', 'Sector', 'Rol', 'Activo'],
            'columnas_claves' => ['id_usuario', 'usuario', 'nombre', 'apellido', 'cargo', 'sector', 'descripcion', 'activo'],
            'data' => $usuarios,
            'acciones' => function ($fila) {
                $id = $fila['id_usuario'];
                $url = URL . '/usuario';
                return '
                    <a href="' . $url . '/edit/' . $id . '" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="' . $url . '/delete/' . $id . '" class="btn btn-sm btn-outline-primary">Eliminar</a>
                    <a href="' . $url . '/activate/' . $id . '" class="btn btn-sm btn-outline-success" onclick="return confirm(\'¿Activar este usuario?\');">Activar</a>
                    <a href="' . $url . '/changePass/' . $id . '" class="btn btn-sm btn-outline-warning">Cambiar clave</a>
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
            'action' => URL . '/usuario/save',
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
                    'action' => URL . '/usuario/save',
                    'values' => $_POST,
                    'errores' => $errores,
                    'tipos' => $tipos,
                    'update' => false
                ]);
                return;
            }
            $contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);

            if ($this->model->insertUsuario($usuario, $nombre, $apellido, $cargo, $sector, $contrasenia, $tipoUsuario)) {
                header("Location: " . URL . "/usuario");
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
            'action' => URL . '/usuario/update/' . $id,
            'values' => [
                'usuario' => $usuario['usuario'],
                'nombre' => $usuario['nombre'],
                'apellido' => $usuario['apellido'],
                'cargo' => $usuario['cargo'],
                'sector' => $usuario['sector'],
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
                    'sector' => $sector,
                    'id_tipo_usuario' => $tipoUsuario
                ];
                $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();
                $this->loadView('usuario/UsuarioForm', [
                    'title' => 'Editar usuario',
                    'action' => URL . '/usuario/update/' . $id,
                    'values' => $usuario,
                    'errores' => $errores,
                    'tipos' => $tipos,
                    'update' => true
                ]);
                return;
            }

            if ($this->model->updateUsuario($id, $usuario, $nombre, $apellido, $cargo, $sector, $tipoUsuario)) {
                header("Location: " . URL . "/usuario");
                exit;
            } else {
                die("Error al actualizar el usuario");
            }
        }
    }

    public function delete($id)
    {
        if ($this->model->deleteUsuario($id)) {
            header("Location: " . URL . "/usuario");
            exit;
        } else {
            die("No se pudo eliminar al usuario.");
        }
    }

    public function activate($id) {
        if($this->model->activateUsuario($id)) {
            header("Location: ". URL . "/usuario");
            exit;
        } else {
            die("No se pudo activar al usuario");
        }
    }

    public function changePass($id) {
        $this->loadView('usuarios/UsuarioFormPass', [
            'title' => 'Cambiar clave',
            'action' => URL .'/usuario/savePass/'. $id,
            'errores' => []
        ]);
    }

    public function savePass($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = trim($_POST["password"]);

            $errores = [];
            if (empty($password)) $errores[] = "El campo nueva contrasenia es obligatorio.";

            if (!empty($errores)) {
                $this->loadView("usuarios/UsuarioFormPass", [
                    'title' => 'Cambiar clave',
                    'action' => URL .'/usuario/savePass/'. $id,
                    'errores' => $errores
                ]);
                return;
            }

            $password = password_hash($password, PASSWORD_DEFAULT);
            if ($this->model->updatePassword($id, $password)) {
                header('Location: '. URL . '/usuario');
                exit;
            } else {
                die("Error al cambiar la clave");
            }
        }
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
                header("Location:" . URL  . 'home');
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }
        }

        // Si hay error, volver a mostrar el formulario con mensaje
        $datos['title'] = "Login";
        $datos['error'] = $error;

       header("Location:" .URL );
    } 
}


}
?>
 