<?php
class UsuarioController extends Control {
    private UsuarioModel $model;
    private TiposUsuariosModel $tipoUsuariosModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->model = $this->loadModel("UsuarioModel");
        $this->tipoUsuariosModel = $this->loadModel("TiposUsuariosModel");
    }

    public function index() {
        $usuarios = $this->model->getAllUsuarios();

        $datos = [
            'title' => 'Lista de Usuarios',
            'urlCrear' => URL . 'usuario/create',
            'columnas' => ['ID', 'Usuario', 'Nombre', 'Apellido', 'Cargo', 'Sector', 'Rol', 'Activo'],
            'columnas_claves' => ['id_usuario', 'usuario', 'nombre', 'apellido', 'cargo', 'sector', 'descripcion', 'activo'],
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

    public function create() {
        $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();

        $datos = array();
        $datos['title'] = 'Crear usuario';
        $datos['action'] = URL . 'usuario/save';
        $datos['values'] = array();
        $datos['errores'] = array();
        $datos['tipos'] = $tipos;
        $datos['update'] = false;

        $this->loadView('usuarios/UsuarioForm', $datos);
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = '';
            if (isset($_POST['usuario'])) {
                $usuario = trim($_POST['usuario']);
            }
            $nombre = '';
            if (isset($_POST['nombre'])) {
                $nombre = trim($_POST['nombre']);
            }
            $apellido = '';
            if (isset($_POST['apellido'])) {
                $apellido = trim($_POST['apellido']);
            }
            $cargo = '';
            if (isset($_POST['cargo'])) {
                $cargo = trim($_POST['cargo']);
            }
            $sector = '';
            if (isset($_POST['sector'])) {
                $sector = trim($_POST['sector']);
            }
            $telefono = '';
            if (isset($_POST['telefono'])) {
                $telefono = trim($_POST['telefono']);
            }
            $email = '';
            if (isset($_POST['email'])) {
                $email = trim($_POST['email']);
            }
            $contrasenia = '';
            if (isset($_POST['password'])) {
                $contrasenia = trim($_POST['password']);
            }
            $tipoUsuario = '';
            if (isset($_POST['tipo_usuario'])) {
                $tipoUsuario = $_POST['tipo_usuario'];
            }

            $errores = array();

            if ($usuario == '') {
                $errores[] = "Ingrese un usuario.";
            } 

            if ($nombre == '') {
                $errores[] = "Ingrese un nombre.";
            }

            if ($apellido == '') {
                $errores[] = "Ingrese un apellido.";
            }

            if ($contrasenia == '') {
                $errores[] = "Ingrese una contrasenia.";
            }

            if ($tipoUsuario == '') {
                $errores[] = "Debe seleccionar un tipo de usuario.";
            }

            if (count($errores) > 0) {
                $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();
                $datos = array();
                $datos['title'] = 'Crear nuevo usuario';
                $datos['action'] = URL . 'usuario/save';
                $datos['values'] = $_POST;
                $datos['errores'] = $errores;
                $datos['tipos'] = $tipos;
                $datos['update'] = false;

                $this->loadView('usuarios/UsuarioForm', $datos);
                return;
            }

            $contraseniaEncriptada = password_hash($contrasenia, PASSWORD_DEFAULT);

            $insertado = $this->model->insertUsuario($usuario, $nombre, $apellido, $cargo, $sector, $telefono, $email, $contraseniaEncriptada, $tipoUsuario);

            if ($insertado == true) {
                header("Location: " . URL . "usuario");
                exit;
            } else {
                die("Error al guardar el usuario");
            }
        }
    }

    public function edit($id) {
        $usuario = $this->model->getUsuarioId($id);
        $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();

        if ($usuario == false) {
            die("Usuario no encontrado");
        }

        $datos = array();
        $datos['title'] = "Editar usuario";
        $datos['action'] = URL . 'usuario/update/' . $id;
        $datos['values'] = array(
            'usuario' => $usuario['usuario'],
            'nombre' => $usuario['nombre'],
            'apellido' => $usuario['apellido'],
            'cargo' => $usuario['cargo'],
            'sector' => $usuario['sector'],
            'id_tipo_usuario' => $usuario['id_tipo_usuario']
        );
        $datos['errores'] = array();
        $datos['tipos'] = $tipos;
        $datos['update'] = true;

        $this->loadView("usuarios/UsuarioForm", $datos);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = '';
            if (isset($_POST['usuario'])) {
                $usuario = trim($_POST['usuario']);
            }
            $nombre = '';
            if (isset($_POST['nombre'])) {
                $nombre = trim($_POST['nombre']);
            }
            $apellido = '';
            if (isset($_POST['apellido'])) {
                $apellido = trim($_POST['apellido']);
            }
            $cargo = '';
            if (isset($_POST['cargo'])) {
                $cargo = trim($_POST['cargo']);
            }
            $sector = '';
            if (isset($_POST['sector'])) {
                $sector = trim($_POST['sector']);
            }
            $telefono = '';
            if (isset($_POST['telefono'])) {
                $telefono = trim($_POST['telefono']);
            }
            $email = '';
            if (isset($_POST['email'])) {
                $email = trim($_POST['email']);
            }
            $tipoUsuario = '';
            if (isset($_POST['tipo_usuario'])) {
                $tipoUsuario = $_POST['tipo_usuario'];
            }

            $errores = array();

            if ($usuario == '') {
                $errores[] = "El usuario es obligatorio.";
            }

            if ($nombre == '') {
                $errores[] = "El nombre es obligatorio.";
            }

            if ($apellido == '') {
                $errores[] = "El apellido es obligatorio.";
            }

            if ($tipoUsuario == '') {
                $errores[] = "Debe seleccionar un tipo de usuario.";
            }

            if (count($errores) > 0) {
                $usuarioArray = array();
                $usuarioArray['id_usuario'] = $id;
                $usuarioArray['usuario'] = $usuario;
                $usuarioArray['nombre'] = $nombre;
                $usuarioArray['apellido'] = $apellido;
                $usuarioArray['cargo'] = $cargo;
                $usuarioArray['sector'] = $sector;
                $usuarioArray['telefono'] = $telefono;
                $usuarioArray['email'] = $email;
                $usuarioArray['id_tipo_usuario'] = $tipoUsuario;

                $tipos = $this->tipoUsuariosModel->getAllTiposUsuarios();

                $datos = array();
                $datos['title'] = 'Editar usuario';
                $datos['action'] = URL . 'usuario/update/' . $id;
                $datos['values'] = $usuarioArray;
                $datos['errores'] = $errores;
                $datos['tipos'] = $tipos;
                $datos['update'] = true;

                $this->loadView('usuarios/UsuarioForm', $datos);
                return;
            }

            $actualizado = $this->model->updateUsuario($id, $usuario, $nombre, $apellido, $cargo, $sector, $telefono, $email, $tipoUsuario);

            if ($actualizado == true) {
                header("Location: " . URL . "usuario");
                exit;
            } else {
                die("Error al actualizar el usuario");
            }
        }
    }

    public function delete($id) {
        $eliminado = $this->model->deleteUsuario($id);
        if ($eliminado == true) {
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
            $password = '';
            if (isset($_POST['password'])) {
                $password = trim($_POST['password']);
            }

            $errores = array();
            if ($password == '') {
                $errores[] = "El campo nueva contrasenia es obligatorio.";
            }

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