<?php
class Core{
    protected $controller;
    protected $method;
    protected $parameters = [];

    public function __construct() {
        $url = $this->getUrl();
        print_r($url);
    }

    public function getUrl() {
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            
            return $url;
        } 
    }
}
?>