<?php
//controlador de controllers

class Views extends Control{

  public function inicio(){
    $datos = [
      "title" => "Inicio"
    ];

    $this->load_controller("UsuarioController", $datos);

    /*
    $this->load_view('inicio', $datos);
    echo "Página de inicio Controller/Views.php";
    */
  }

  public function update($id){
    if(empty($id)){
      exit("No se estableció el parametro 'id'");
    }else{
      echo $id[2];
    }
  }
  
}

?>