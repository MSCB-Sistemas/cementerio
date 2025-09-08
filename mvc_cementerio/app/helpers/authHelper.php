<?php
function isLoggedIn(){
    // Solo revisa si hay usuario en la sesión
    return isset($_SESSION['usuario_id']);
}

function currentUser(): ?array 
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

    if(isset($_SESSION['usuario_permisos'])){
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
function requirePermission(string|array $permisos, ?string $redirect = null): void 
{
    // Base y rutas seguras (sin //)
    $base     = rtrim(URL, '/');
    $loginUrl = $base . '/login';
    if (!$redirect)
        $redirect = $base . '/error-permisos';

    // 1) Si no hay sesión, a login
    if (!isLoggedIn()) {
        header('Location: ' . $loginUrl);
        exit;
    }
    // 2) Check de permisos (string o array → OR lógico)
    $ok = false;

    if (is_array($permisos)) {
        // OR lógico: alcanza con uno
        foreach ($permisos as $p) {
            if (userHasPermission($p)) { 
                $ok = true; 
                break; 
            }
        }
    } else {
        $ok = userHasPermission($permisos);
    }
    
    // 3) Sin permiso → redirigir a página de 403 “amigable”
    if (!$ok) {
        header('Location: ' . rtrim(URL,'/') . '/error-permisos');
        exit;
    }
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