<?php
function isLoggedIn(){
    // Solo revisa si hay usuario en la sesión
    return isset($_SESSION['usuario_id']);
}

function currentUser(): array 
{
    // Devuelve el array completo del usuario (id, nombre, rol, permisos)
    if (!isset($_SESSION['usuario_id'])) 
        return null;

    return [
        'id'        => (int)($_SESSION['usuario_id']),
        'nombre'    => $_SESSION['usuario_nombre'],
        'apellido'  => $_SESSION['usuario_apellido'],
        'rol'       => $_SESSION['usuario_tipo'],
        'permisos'  => $_SESSION['usuario_permisos'],
    ];
}

function userHasPermission(string $permiso): bool 
{
    if (!isLoggedIn())
        return false;

    if($_SESSION['usuario_permisos']){
        $permisos = $_SESSION['usuario_permisos'];
    }else{
        $permisos = [];
    }
    return in_array($permiso, $permisos, true);
}

/**
 * Middleware: exige uno o varios permisos.
 * Si no cumple → redirige.
 */
function requirePermission($permisos, ?string $fallback = null): void 
{
    // Arma URLs seguras sin dobles barras
    $base     = rtrim(URL, '/');
    $loginUrl = $base . '/login';
    if (!$fallback)
        $fallback = $base . '/error-permisos';

    // Si no hay sesión, a login
    if (!isLoggedIn()) {
        header('Location: ' . $loginUrl);
        exit;
    }

    // Acepta string o array → OR lógico (con que tenga uno, pasa)
    $permisos  = (array)$permisos;

    foreach ($permisos as $p) 
        if (userHasPermission($p)) 
            return; // ✅ tiene permiso, continuar
    
     // ❌ no tiene ninguno: bloqueamos
    $_SESSION['flash_error'] = 'No tenés permisos para acceder.';
    header('Location: '. $fallback); 
    exit;
}

/*
function requireLogin()
{
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ' . URL . 'login');
        exit;
    }
}*/
/*
function isLoggedInAdmin()
{
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 1;
}
?>*/