<?php
class Control {
  public function load_model($model) {
    require_once APP . '/models/' . $model . '.php';

    return new $model;
  }

  public function load_view($view, $datos = [], $layout = 'main') {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $viewFile = APP . '/views/pages/' . $view . '.php';

    if (file_exists($viewFile)) {
      if ($layout) {
        $viewPath = $viewFile;
        require_once APP . "/views/layouts/{$layout}.php";
      } else {
        require_once $viewFile;
      }
    } else {
      die($viewFile);
    }
  }
}
?>