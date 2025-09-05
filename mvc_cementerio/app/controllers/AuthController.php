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
                $this->loadView('loginView', $datos, 'login');
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
                $_SESSION['usuario_tipo'] = (int)$usuario['id_tipo_usuario'];
                
                // Permisos del rol (desde BD) → array de strings
                $_SESSION['usuario_permisos'] = $this->permisoModel->getPermisosPorRol($usuario['id_tipo_usuario']);

                // Remember-me (opcional)
                if ($remember) {
                    $token    = bin2hex(random_bytes(32));
                    $duracion = 60 * 60 * 24 * 30; // 30 días

                    // Guardar token en BD
                    $tokenModel = $this->loadModel('RememberTokensModel');
                    $tokenModel->createRememberMeToken($_SESSION['usuario_id'], $token, $duracion);

                    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

                    // Cookies seguras (usar misma config al borrar)
                    setcookie('remember_token', $token, [
                        'expires'  => time() + $duracion,
                        'path'     => '/',
                        'secure'   => $secure,
                        'httponly' => true,
                        'samesite' => 'Strict',
                    ]);

                    setcookie('id_usuario', (string)$_SESSION['usuario_id'], [
                        'expires'  => time() + $duracion,
                        'path'     => '/',
                        'secure'   => $secure,
                        'httponly' => true,
                        'samesite' => 'Strict',
                    ]);
                }

                header('Location: ' . URL . 'home');
                exit;
            } 
            // Credenciales inválidas
            $datos['error'] = 'Credenciales incorrectas';
            $this->loadView('loginView', $datos, 'login');
            return;
        }
        // GET
        #$this->checkRememberMeToken();  // si rehidrata, debería redirigir internamente a home
        $this->loadView('loginView', $datos, 'login');
        
    }

    public function logout() 
    {
        if (isset($_SESSION['usuario_id'])){
            $idUsuario = $_SESSION['usuario_id'];
        } elseif (isset($_COOKIE['id_usuario'])){
            $idUsuario = $_COOKIE['id_usuario'];
        } else {
            $idUsuario = null;
        }
    
        if (isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];
        } else {
            $token = null;
        }

        if ($idUsuario && $token) {
            $tokenModel = $this->loadModel('RememberTokensModel');
            $tokenModel->deleteRememberMeToken((int)$idUsuario, $token);
        }

        // Borrar cookies (usar mismos parámetros que al setearlas)
        setcookie('remember_token', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off', true);
        setcookie('id_usuario',     '', time() - 3600, '/', '', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off', true);

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