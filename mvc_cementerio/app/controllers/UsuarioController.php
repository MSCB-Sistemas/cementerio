<?php
class UsuarioController extends Control {
    private UsuarioModel $model;
    private TiposUsuariosModel $tipoUsuariosModel;

    public function __construct() {
        $this->model = $this->loadModel("UsuarioModel");
        $this->tipoUsuariosModel = $this->loadModel("TiposUsuariosModel");
    }

    public function index() {
        $usuarios = $this->model->getAllUsuarios();

        $datos = array();
        $datos['title'] = 'Lista de Usuarios';
        $datos['urlCrear'] = URL . 'usuario/create';
        $datos['columnas'] = array('ID', 'Usuario', 'Nombre', 'Apellido', 'Cargo', 'Sector', 'Telefono', 'Email', 'Rol', 'Activo');
        $datos['columnas_claves'] = array('id_usuario', 'usuario', 'nombre', 'apellido', 'cargo', 'sector', 'telefono', 'email', 'descripcion', 'activo');
        $datos['data'] = $usuarios;
        $datos['acciones'] = function ($fila) {
            $id = $fila['id_usuario'];
            $url = URL . 'usuario';
            return '
                <a href="' . $url . '/edit/' . $id . '" class="btn btn-sm btn-outline-primary">Editar</a>
                <a href="' . $url . '/delete/' . $id . '" class="btn btn-sm btn-outline-primary">Eliminar</a>
                <a href="' . $url . '/activate/' . $id . '" class="btn btn-sm btn-outline-success" onclick="return confirm(\'¿Activar este usuario?\');">Activar</a>
                <a href="' . $url . '/changePass/' . $id . '" class="btn btn-sm btn-outline-warning">Cambiar clave</a>
            ';
        };
        $datos['errores'] = array();

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

    public function activate($id) {
        $activado = $this->model->activateUsuario($id);
        if ($activado == true) {
            header("Location: ". URL . "usuario");
            exit;
        } else {
            die("No se pudo activar al usuario");
        }
    }

    public function changePass($id) {
        $datos = array();
        $datos['title'] = 'Cambiar clave';
        $datos['action'] = URL .'usuario/savePass/'. $id;
        $datos['errores'] = array();

        $this->loadView('usuarios/UsuarioFormPass', $datos);
    }

    public function savePass($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = '';
            if (isset($_POST['password'])) {
                $password = trim($_POST['password']);
            }

            $errores = array();
            if ($password == '') {
                $errores[] = "El campo nueva contrasenia es obligatorio.";
            }

            if (count($errores) > 0) {
                $datos = array();
                $datos['title'] = 'Cambiar clave';
                $datos['action'] = URL .'usuario/savePass/'. $id;
                $datos['errores'] = $errores;

                $this->loadView("usuarios/UsuarioFormPass", $datos);
                return;
            }

            $passwordEncriptada = password_hash($password, PASSWORD_DEFAULT);
            $actualizado = $this->model->updatePassword($id, $passwordEncriptada);

            if ($actualizado == true) {
                header('Location: '. URL . 'usuario');
                exit;
            } else {
                die("Error al cambiar la clave");
            }
        }
    }

    public function login() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $datos = array();
            $datos['title'] = 'login';
            $datos['error'] = '';
            $this->loadView('login/Login', $datos);
            return;
        }

        $usuario = '';
        if (isset($_POST['usuario'])) {
            $usuario = trim($_POST['usuario']);
        }

        $contrasenia = '';
        if (isset($_POST['contrasenia'])) {
            $contrasenia = trim($_POST['contrasenia']);
        }

        $error = '';

        if ($usuario == '' || $contrasenia == '') {
            $error = "Por favor complete ambos campos.";
        } else {
            $usuarioEncontrado = $this->model->verificarLogin($usuario, $contrasenia);

            if ($usuarioEncontrado != false) {
                $_SESSION['usuario'] = array();
                $_SESSION['usuario']['id'] = $usuarioEncontrado['id_usuario'];
                $_SESSION['usuario']['nombre'] = $usuarioEncontrado['nombre'];
                $_SESSION['usuario']['rol'] = $usuarioEncontrado['descripcion'];
                $_SESSION['usuario']['activo'] = $usuarioEncontrado['activo'];

                header("Location: " . URL . "/home");
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }
        }

        $datos = array();
        $datos['title'] = 'login';
        $datos['error'] = $error;
        $this->loadView('login/Login', $datos);
    }
}
?>