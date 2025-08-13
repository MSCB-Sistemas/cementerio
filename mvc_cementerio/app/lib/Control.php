<?php
class Control
{
    public function __construct()
    {
        $this->checkRememberMeToken();
    }

    public function loadModel($model)
    {
        require_once '../app/models/' . $model . '.php';

        return new $model;
    }

    public function loadView($view, $datos = [], $layout = 'main')
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $viewFile = APP . '/views/pages/' . $view . '.php';

        if (file_exists($viewFile)) {
            if ($layout) {
                $viewPath = $viewFile;
                require_once APP . "/views/layout/{$layout}.php";
            } else {
                require_once $viewFile;
            }
        } else {
            die($viewFile);
        }
    }

    protected function checkRememberMeToken()
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

    protected function requireLogin() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . URL . 'login');
            exit;
        }
    }
}
?>