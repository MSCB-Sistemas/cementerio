<?php
echo "<h3>Municipalidad San Carlos de Bariloche</h1>";

require_once 'config/config.php';

spl_autoload_register( function ($lib) {
    require_once 'lib/' . $lib . '.php';
});

?>
