<?php

class core{

    protected $controller;
    protected $method;
    protected $parameters = [];

    public function __construct() {
        $url = $this->getUrl();
        print_r($url);

        // Valor por defecto
        $this->controller = 'views';
        $this->method = 'inicio';

        //--Controllers
        if (!empty($url) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->controller = ucwords($url[0]);
            unset($url[0]); //destruye el valor del indice[0]
        }
        
        // Carga el archivo PHP que contiene la definición de la clase del controlador.
        require_once '../app/controllers/' . $this->controller . '.php';
        // Se crea un instancia(objeto) de la clase y se guarda en $this->controller. 
        $this->controller = new $this->controller;

        //--Methods
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->parameters = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], [$this->parameters]);
    }


    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');    // quitar barras iniciales/finales
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);  // Dividir en un array
            
            print_r($url);
            return $url;
        }
    }
}
