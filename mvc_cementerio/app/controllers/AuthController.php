<?php
class AuthController extends Control {
    public function login() {
        $datos = ['title' => 'Login'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $user = $_POST['user'];
            $password = trim($_POST['password']);

            if (empty($user) || empty($password)) {
                $datos['error'] = 'Debe ingresar usuario y contraseña';
                $this->loadView('loginView', $datos, 'login');
                exit;
            }

            $usuarioModel = $this->loadModel('UsuarioModel');
            $usuario = $usuarioModel->getUsuarioByNombreUsuario($user);

            if ($usuario && password_verify($password, $usuario['contrasenia'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_apellido'] = $usuario['apellido'];
                $_SESSION['usuario_tipo'] = $usuario['id_tipo_usuario'];

                header('Location: ' . URL . 'home');
                exit;
            } else {
                $datos['error'] = 'Credenciales incorrectas';
                $this->loadView('loginView', $datos, 'login');
            }
        } else {
            $this->loadView('loginView', $datos, 'login');
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();

        header('Location: ' . URL . 'login');
        exit;
    }
}
?>