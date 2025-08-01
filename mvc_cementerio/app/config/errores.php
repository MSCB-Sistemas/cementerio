<?php

function errorMensaje($codigo, $extra = '') {
    $mensajes = [
        '404' => 'Error 404: No encontrado',
        '500' => 'Error 500: Error del servidor',
        '403' => 'Error 403: Acceso denegado',
        '401' => 'Error 401: No autorizado',
        '400' => 'Error 400: Solicitud inválida',
        '405' => 'Error 405: Método no permitido',
        '999' => 'Error desconocido'
    ];

    if (isset($mensajes[$codigo])) {
        return $mensajes[$codigo] . ($extra ? ': ' . $extra : '');
    }

    // Si no existe, devolver mensaje por defecto
    return 'Error indefinido' . ($extra ? ': ' . $extra : '');
}

?>