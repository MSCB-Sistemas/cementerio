<?php
function isLoggedIn():bool
{
    // Solo revisa si hay usuario en la sesión
    return !empty($_SESSION['usuario_id']);
}

function currentUser(): ?array 
{
    // Devuelve el array completo del usuario (id, nombre, rol, permisos)
    if (!isLoggedIn()) { return null }
    return [
        'id'        => (int)($_SESSION['usuario_id']),
        'nombre'    => $_SESSION['usuario_nombre'],
        'apellido'  => $_SESSION['usuario_apellido'],
        'rol'       => (int)$_SESSION['usuario_tipo'],
        'permisos'  => $_SESSION['usuario_permisos'],
    ];
}

function userHasPermission(string $permiso): bool 
{
    if (!isLoggedIn())  { return false }

    if(isset($_SESSION['usuario_permisos'])){
        $permisos = $_SESSION['usuario_permisos'];
    }else{
        $permisos = [];
    }
    return in_array($permiso, $permisos, true);
}

/**
 * Middleware: exige uno o varios permisos (OR lógico).
 * Si no cumple → redirige (por defecto /error-permisos).
 */
function requirePermission(string|array $permisos, ?string $redirect = null): void 
{
    // Base y rutas seguras (sin //)
    $base     = rtrim(URL, '/');
    $loginUrl = $base . '/login';
    if (!$redirect)
        $redirect = $base . '/error-permisos';

    // 1) Si no hay sesión → login
    if (!isLoggedIn()) {
        //Enviar código de estado 303 en la redirección (post-login / post-checks).
        header('Location: ' . $loginUrl, true, 303); 
        exit;
    }
    // 2) Check de permisos (string o array → OR lógico)
    foreach ((array)$permisos as $p) {
        if (userHasPermission($p)) {
            return; // autorizado → continuar con el flujo normal
        }
    }
    
    // 3) Sin permiso → redirigir a página “amigable”
    header('Location: ' . $fallback, true, 303);
    exit;
}
