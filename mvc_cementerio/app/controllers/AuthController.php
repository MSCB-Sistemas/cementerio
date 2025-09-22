<?php
class AuthController extends Control 
{
    private PermisoModel $permisoModel;

    public function __construct()
    {
        // Carga el modelo de permisos una vez
        $this->permisoModel = $this->loadModel('PermisoModel');
    }


    public function login() 
    {
        $datos = ['title' => 'Login'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            $user     = trim($_POST['user']);
            $password = trim($_POST['password']);
            
            if (isset($_POST['remember'])) {
                $remember = true;
            } else {
                $remember = false;
            }


            if (empty($user) || empty($password)) {
                $datos['error'] = 'Debe ingresar usuario y contraseña';
                $this->loadView('LoginView', $datos, 'login');
                exit;
            }

            $usuarioModel = $this->loadModel('UsuarioModel');
            $usuario = $usuarioModel->getUsuarioByNombreUsuario($user);

            if ($usuario && password_verify($password, $usuario['contrasenia'])) 
            {
                // Regenerar sesión para evitar fixation
                if (session_status() === PHP_SESSION_ACTIVE) {
                    session_regenerate_id(true);
                }

                // Sesión
                $_SESSION['usuario_id'] = (int)$usuario['id_usuario'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_apellido'] = $usuario['apellido'];
                $_SESSION['usuario_tipo'] = $usuario['id_tipo_usuario'];

                if ($remember) {
                    $this->createRememberMeToken($usuario['id_usuario']);
                }

                header('Location: ' . URL . 'home');
                exit;
            } else {
                $datos['error'] = 'Credenciales incorrectas';
                $this->loadView('loginView', $datos, 'login');
            }
        } else {
            $this->checkRememberMeToken();
            $this->loadView('loginView', $datos, 'login');
        }
        // GET
        #$this->checkRememberMeToken();  // si rehidrata, debería redirigir internamente a home
        $this->loadView('loginView', $datos, 'login');
        
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $idUsuario = $_SESSION['usuario_id'] ?? $_COOKIE['id_usuario'] ?? null;
        $token = $_COOKIE['remember_token'] ?? null;

        if ($idUsuario && $token) {
            $tokenModel = $this->loadModel('RememberTokensModel');
            $tokenModel->deleteRememberMeToken($idUsuario, $token);
        }

        setcookie('remember_token','', time() - 3600,'/');
        setcookie('id_usuario','', time() - 3600,'/');

        //login: setcookie('remember_token', $token, time()+$duracion, '/', '', true, true);

        // Limpiar sesión
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        header('Location: ' . URL . 'login');
        exit;
    }
}
?>