<?php
#Encargado de Cargar los modelos y las vistas 

class Control {
  public function load_model($model) {
    require_once '../app/models/' . $model . '.php';

    return new $model;
  }

  public function load_view($view, $datos = []) {
    // Extraer variables del array para poder usarlas en la vista
    if(file_exists('../app/views/pages/' . $view . '.php')){
      require_once '../app/views/pages/' . $view . '.php';
    }
    else{
      die("404 NOT FOUND");
    }
  }
  
}
?>