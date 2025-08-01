<?php
echo "<h3>Municipalidad San Carlos de Bariloche</h1>";

require_once 'config/config.php';





// ni idea
spl_autoload_register( function ($lib) {
    $direccion = 'lib/' . $lib . '.php';
    require_once ($direccion);
});

?>
