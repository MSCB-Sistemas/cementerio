<?php
class Control
{
    public function __construct()
    {
        // Se deja el “auto refresh” de remember-me acá,
        // El inicio de sesión se hace en init.php
        $this->refreshRememberMeIfNeeded();
    }

    protected function loadModel($model)
    {
        require_once APP .'/models/' . $model . '.php';
        return new $model;
    }

    protected function loadView(string $view, array $datos = [], string $layout = 'main')
    {
        $viewFile = APP . '/views/pages/' . $view . '.php';

        if (!file_exists($viewFile)) { die($viewFile); }

        // Variables disponibles en la vista
        extract($datos, EXTR_SKIP);

        if ($layout) {
            $viewPath = $viewFile;  // queda disponible para el layout
            require_once APP . "/views/layout/{$layout}.php";
        } else {
            require_once $viewFile;
        }
    }
    
    /** RBAC (permisos): Getters rápidos sobre la sesion */
    protected function isLogin(): bool  { return !empty($_SESSION['usuario_id']); }
    protected function userId(): ?int   
    { 
        if (isset($_SESSION['usuario_id'])) {
            return (int)$_SESSION['usuario_id'];
        } else {
            return null;
        }
    }

    protected function roleId(): ?int   
    { 
        if (isset($_SESSION['usuario_tipo'])) {
            return (int)$_SESSION['usuario_tipo'];
        } else {
            return null;
        }
    }

    protected function permisos(): array 
    {   
        if (isset($_SESSION['usuario_permisos'])) {
            $permisos = $_SESSION['usuario_permisos'];
        } else {
            $permisos = [];
        }
        return $permisos;
    }

    /** REMEMBER-ME **************************************************/
    // No abre sesión (ya está abierta en init.php). No redirige.
    protected function checkRememberMeToken(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (
            !isset($_SESSION["usuario_id"]) &&
            isset($_COOKIE["remember_token"]) &&
            isset($_COOKIE["id_usuario"])
        ) {
            $token = $_COOKIE["remember_token"];
            $usuarioId = $_COOKIE["id_usuario"];

            $tokenModel = $this->loadModel("RememberTokensModel");
            $usuarioData = $tokenModel->validateRememberMeToken($usuarioId, $token);

            if ($usuarioData) {
                $_SESSION["usuario_id"] = $usuarioData["id_usuario"];
                $_SESSION["usuario_nombre"] = $usuarioData["nombre"];
                $_SESSION["usuario_apellido"] = $usuarioData["apellido"];
                $_SESSION["usuario_tipo"] = $usuarioData["id_tipo_usuario"];

                $this->createRememberMeToken($usuarioData["id_usuario"]);
                header("Location: " . URL . "home");
                exit;
            }
        }
    }

    protected function createRememberMeToken($id_usuario) {
        $token = bin2hex(random_bytes(32));
        $expiry = time() + 60 * 60 * 24 * 30;

        $tokenModel = $this->loadModel("RememberTokensModel");
        $tokenModel->insertRememberMeToken($id_usuario, $token, $expiry);

        $secure = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on";
        setcookie("remember_token", $token, $expiry,'/', '', $secure, true);
        setcookie("id_usuario", $id_usuario, $expiry,'/', '', $secure, true);
    }

    protected function requireLogin(string $fallback = URL . 'login'): void
    {
        // NO session_start() acá: la sesión ya se abrió en init.php
        $loggedIn = isset($_SESSION['usuario_id']);

        if (!$loggedIn) {
            $_SESSION['flash_error'] = 'Debés iniciar sesión.';
            header("Location: " . URL . 'login');
            exit;
        }
    }
}
?>