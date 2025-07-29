<?php
echo "<h1>Welcome to the Cementerio MVC App</h1>";

spl_autoload_register(function ($lib){
    require_once 'lib/' . $lib . '.php';
});
?>