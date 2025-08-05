<?php
class Control
{
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

        $viewFile = APP . 'views/pages' . $view . '.php';

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
}
?>