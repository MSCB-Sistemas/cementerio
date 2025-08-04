<?php
class Core {
    protected $controller;
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();

        if (!$url || empty($url[0])) {
            session_start();
            if (isset($_SESSION['usuario_id'])) {
                $this->controller = 'Views';
                $this->method = 'inicio';
            } else {
                $this->controller = 'Auth';
                $this->method = 'login';
            }
        } else if (file_exists(('../app/controllers/' . ucwords($url[0]) . '.php'))) {
            $this->controller = ucwords($url[0]);
            unset($url[0]);
        } else {
            die("Controlador no encontrado");
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
    }
}
?>