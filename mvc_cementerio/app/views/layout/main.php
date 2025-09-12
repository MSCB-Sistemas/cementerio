<?php 
$user = currentUser();

// $can: verifica si el usuario tiene un permiso
$can = function($perm) use ($user) 
{
    if ($user && isset($user['permisos']) && is_array($user['permisos'])) {
        if (in_array($perm, $user['permisos'])) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
};

// $canAny: devuelve true si tiene al menos uno de los permisos del array
$canAny = function(array $perms) use ($can) {
    foreach ($perms as $p) {
        if ($can($p)) {
            return true;
        }
    }
    return false;
};

$base = rtrim(URL, '/');

// Construcción de $activePath
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

$MENU = [
  ['label'=>'Inicio', 'href'=>"$base/home", 'icon'=>'home', 'perms'=>[]],
  ['label'=>'Listas', 'href'=>"$base/estadisticas", 'icon'=>'chart', 'perms'=>['ver_estadisticas']],
  ['label'=>'Alta, Baja y Modificación', 'icon'=>'table', 'perms'=>[], 'children'=>[
    ['label'=>'Usuarios',        'href'=>"$base/usuario",        'perms'=>['ver_usuario']],
    ['label'=>'Deudos',          'href'=>"$base/deudo",          'perms'=>[]],
    ['label'=>'Difuntos',        'href'=>"$base/difunto",        'perms'=>['ver_difunto']], // opcional
    ['label'=>'Estados Civiles', 'href'=>"$base/estadoCivil",    'perms'=>[]],
    ['label'=>'Parcelas',        'href'=>"$base/parcela",        'perms'=>[]],
    ['label'=>'Ubicaciones',     'href'=>"$base/ubicacion",      'perms'=>[]],
    ['label'=>'Orientaciones',   'href'=>"$base/orientaciones",  'perms'=>[]],
    ['label'=>'Sexos',           'href'=>"$base/sexo",           'perms'=>[]],
    ['label'=>'Nacionalidades',  'href'=>"$base/nacionalidades", 'perms'=>[]],
    ['label'=>'Tipos de parcela','href'=>"$base/tipoParcela",    'perms'=>[]],
    ['label'=>'Tipos de usuario','href'=>"$base/tipoUsuario",    'perms'=>['ver_tipo_usuario']],
    ['label'=>'Pagos',           'href'=>"$base/pago",           'perms'=>[]],
  ]],
];
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