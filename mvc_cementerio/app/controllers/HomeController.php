<?php
class HomeController extends Control
{
    private UsuarioModel $model;
    public function __construct()
    {
        $this->model = $this->loadModel("UsuarioModel");
    }

    public function index()
    {
        $this->loadView('home/HomeView');
    }


    public function login() {
        $this->loadView('loginView');
    }
}

