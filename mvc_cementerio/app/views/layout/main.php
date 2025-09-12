<?php 
$user = currentUser();
$base = rtrim(URL, '/');

// $can: verifica si el usuario tiene un permiso
$can = function($perm) use ($user) {
    if ($perm === '__login__') {
        return (bool)$user;   // cualquiera logueado
    }

    if ($user) {
        if (isset($user['permisos']) && in_array($perm, $user['permisos'])) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
};

// $canAny: devuelve true si tiene al menos uno de los permisos del array
$canAny = function(array $perms) use ($can) 
{
    if (empty($perms)) return true;       // sin guard => visible
    foreach ($perms as $p) {
        if ($can($p)) {
            return true;
        }
    }
    return false;
};

$guardToPerms = function($guard) {
    if ($guard === '__public__' || $guard === null) return [];        // visible a todos
    if ($guard === '__login__') return ['__login__'];                 // requiere login
    if (is_string($guard)) return [$guard];                           // permiso único
    if (is_array($guard))  return $guard;                             // OR de permisos
    return [];
};

// Construcción de Ruta activa (para marcar “active”)
$requestPath = '';
if (isset($_SERVER['REQUEST_URI'])) {
    $parsed = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($parsed !== null) {
        $requestPath = $parsed;
    } else {
        $requestPath = '';
    }
} else {
    $requestPath = '';
}

$activePath = trim($requestPath, '/');

// 1) Cargar rutas compartidas
$routes = require APP . '/config/routes.php';

// 2) Elegimos solo “rutas de índice” (sin slash), que tienen página listable
$indexRoutes = [];
foreach ($routes as $key => [$ctrl, $method, $guard]) 
{
    if (strpos($key, '/') === false) 
    {
        // ignorar login/logout/públicas que no quieras en el menú
        if (in_array($key, ['', 
                            'login', 
                            'logout', 
                            'error-permisos'], 
                    true)) 
            continue;
        $indexRoutes[$key] = $routes[$key];
        //Ese array es la base para construir el $MENU dinámico del sidebar.
    }
}

// 3) Mapeo de labels y grupos (controlás texto y agrupación acá)
$labelFor = [
  'home'            => 'Inicio',
  'estadisticas'    => 'Listas',
  'usuario'         => 'Usuarios',
  'deudo'           => 'Deudos',
  'difunto'         => 'Difuntos',
  'estadoCivil'     => 'Estados Civiles',
  'parcela'         => 'Parcelas',
  'ubicacion'       => 'Ubicaciones',
  'orientaciones'   => 'Orientaciones',
  'sexo'            => 'Sexos',
  'nacionalidades'  => 'Nacionalidades',
  'tipoParcela'     => 'Tipos de parcela',
  'tipoUsuario'     => 'Tipos de usuario',
  'pago'            => 'Pagos',
];

$groupFor = [
  'home'         => null,           // ítems sueltos
  'estadisticas' => null,
  // Todo lo demás al grupo ABM:
  'usuario'        => 'ABM',
  'deudo'          => 'ABM',
  'difunto'        => 'ABM',
  'estadoCivil'    => 'ABM',
  'parcela'        => 'ABM',
  'ubicacion'      => 'ABM',
  'orientaciones'  => 'ABM',
  'sexo'           => 'ABM',
  'nacionalidades' => 'ABM',
  'tipoParcela'    => 'ABM',
  'tipoUsuario'    => 'ABM',
  'pago'           => 'ABM',
];

// 4) Construcción del $MENU
$MENU = [];
$abmChildren = [];

foreach ($indexRoutes as $path => $def) 
{
    [$ctrl, $method, $guard] = $def;
    $label = $labelFor[$path] ?? ucfirst($path);
    $perms = $guardToPerms($guard);
    $href  = $base . '/' . $path;
    $group = $groupFor[$path] ?? 'ABM'; // por defecto mandamos al grupo ABM

    // Ítems sueltos (home, estadísticas, etc.)
    if ($group === null) {
        $MENU[] = ['label' => $label, 'href' => $href, 'perms' => $perms];
        continue;
    }

    // Hijos del grupo ABM
    if ($group === 'ABM') {
        $abmChildren[] = ['label' => $label, 'href' => $href, 'perms' => $perms];
    }

    // Insertamos el grupo ABM si quedó con elementos
    if (!empty($abmChildren)) {
        $MENU[] = [
            'label' => 'Alta, Baja y Modificación',
            'perms' => [],                // visible para todos los logueados; cada hijo filtra lo suyo
            'children' => $abmChildren
        ];
    }
}
?>

<?php require_once APP . '/views/inc/header.php' ?>

<body>
    <main class="d-flex flex-nowrap" style="min-height: 100vh">
        <?php require_once APP . '/views/inc/sidebar.php'; ?>
        <div class="flex-grow-1 p-3">
            <?php require_once $viewPath; ?>
        </div>
    </main>

<?php require_once APP . '/views/inc/footer.php' ?>