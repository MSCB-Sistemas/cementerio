<?php
class ErrorController extends Control {
    public function permisosError() {
        // podés cargar una vista o reutilizar tu helper de errores
        echo errorMensaje('403', 'No tenés permisos para acceder a esta sección.');
        exit;
    }
}
?>
