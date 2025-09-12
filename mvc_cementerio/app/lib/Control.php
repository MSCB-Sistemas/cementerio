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

        // FLASH de error o confirmacion de algún middleware/controlador.
        if (isset($_SESSION['flash_error'])) {
            $datos['flash_error'] = $_SESSION['flash_error'];
        
            // los borra en la sesión así no aparece en el proximo request
            unset($_SESSION['flash_error']);
        } else {
            
            // La vista lo recibe solo en la primera carga
            $datos['flash_error'] = null;
        }
        
        if (isset($_SESSION['flash_ok'])) {
            $datos['flash_ok'] = $_SESSION['flash_ok'];
            unset($_SESSION['flash_ok']);
        } else {
            $datos['flash_ok'] = null;
        }

        // Variables disponibles en la vista
        extract($datos, EXTR_SKIP);

        if ($layout) {
            $viewPath = $viewFile;  // el layout hace require de este path
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

    protected function can(string $permiso): bool 
    {   
        return in_array($permiso, $this->permisos(), true);
    }

    protected function requirePermissionInController(string|array $permisos, ?string $fallback = null): void 
    {
        requirePermission($permisos, $fallback); // reusa el helper global
    }

    protected function fallback$fallback(string $path): void
    {
        $base = rtrim(URL, '/');
        header('Location: ' . $base . '/' . ltrim($path, '/'));
        exit;
    }

    /** ===== Remember-me (token en claro) ===== */    
    // No abre sesión (ya está abierta en init.php). No redirige.
    protected function refreshRememberMeIfNeeded(): void
    {
        if ($this->isLogin()) return;

        if (isset($_COOKIE["remember_token"])){
            $rawToken = $_COOKIE["remember_token"];
        }else{
            $rawToken = null;
        }

        if (isset($_COOKIE["id_usuario"])){
            $usuarioId = (int)$_COOKIE["id_usuario"];
        }else{
            $usuarioId = null;
        }

        if (!$rawToken || !$usuarioId) return;

        // Validar contra BD (token en claro)
        $tokenModel = $this->loadModel("RememberTokensModel");
        $usuarioData = $tokenModel->validateRememberMeToken((int)$usuarioId, $token);
        if(!$usuarioData) return;   // token inválido → no se auto-loguea

        // Rehidratar sesión (pone TODAS las claves que usa toda tu app)
        $_SESSION["usuario_id"] = $usuarioData["id_usuario"];
        $_SESSION["usuario_nombre"] = $usuarioData["nombre"];
        $_SESSION["usuario_apellido"] = $usuarioData["apellido"];
        $_SESSION["usuario_tipo"] = (int)$usuarioData["id_tipo_usuario"];

        // Cargar permisos de rol
        $permisoModel = $this->loadModel('PermisoModel');
        $_SESSION['usuario_permisos'] = $permisoModel->getPermisosPorRol($_SESSION['usuario_tipo']);

        // Rotar token (defensa contra replay)
        $this->createRememberMeToken($_SESSION['usuario_id']);
    }

    protected function createRememberMeToken(int $id_usuario): void 
    {
        $rawToken = bin2hex(random_bytes(32));
        $expiry = time() + 60 * 60 * 24 * 30;   //30 días

        // Guarda token en BD
        $tokenModel = $this->loadModel("RememberTokensModel");
        $tokenModel->insertRememberMeToken($id_usuario, $token, $expiry);

        $secure = (!empty($_SERVER['HTTPS']) && $_SERVER["HTTPS"] === "on");

        // Cookies modernas (sin redireccionar)
        setcookie('remember_token', $rawToken, [
            'expires'  => $expiry,
            'path'     => '/',
            'domain'   => '',
            'secure'   => $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        setcookie('id_usuario', (string)$id_usuario, [
            'expires'  => $expiry,
            'path'     => '/',
            'domain'   => '',
            'secure'   => $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }

    protected function requireLogin(string $fallback = URL . 'login'): void
    {
        // NO session_start() acá: la sesión ya se abrió en init.php
        if (!($this->isLogin())) {
            $_SESSION['flash_error'] = 'Debés iniciar sesión.';
            header('Location: ' . rtrim($fallback, '/'));
            exit;
        }
    }
}
?>