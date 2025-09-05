<?php
// Abre sesión y carga helpers
require_once __DIR__ . '/../app/init.php';

$base = '/cementerio/mvc_cementerio';

// ====== Definición de rutas: 'ruta' => [Controller, method, guard] ======
// guards:
//   - '__public__'  => accesible sin login
//   - '__login__'   => requiere estar logueado
//   - 'guard_x'   => requiere ese guard RBAC (OR si pasas array de guards)
$routes = [

    // Login / Home / Estadísticas
    ''                => ['AuthController',       'login',        '__public__'],
    'login'           => ['AuthController',       'login',        '__public__'],
    'logout'          => ['AuthController',       'logout',       '__login__'],
    'home'            => ['HomeController',       'index',        '__login__'],
    'estadisticas'    => ['EstadisticasController','index',       'ver_estadisticas'],

    // Usuario 
    'usuario'         => ['UsuarioController',    'index',        'ver_usuario'],
    'usuario/create'  => ['UsuarioController',    'create',       'crear_usuario'],
    'usuario/save'    => ['UsuarioController',    'save',         'crear_usuario'],
    'usuario/edit'    => ['UsuarioController',    'edit',         'editar_usuario'],
    'usuario/update'  => ['UsuarioController',    'update',       'editar_usuario'],
    'usuario/delete'  => ['UsuarioController',    'delete',       'eliminar_usuario'],
    'usuario/activate'=> ['UsuarioController',    'activate',     'editar_usuario'],
    'usuario/changePass'=>['UsuarioController',   'changePass',   '__login__'],
    'usuario/savePass'=> ['UsuarioController',    'savePass',     '__login__'],

    // Difunto
    'difunto'         => ['DifuntoController',    'index',        'ver_difunto'],
    'difunto/create'  => ['DifuntoController',    'create',       'crear_difunto'],
    'difunto/save'    => ['DifuntoController',    'save',         'crear_difunto'],
    'difunto/edit'    => ['DifuntoController',    'edit',         'editar_difunto'],
    'difunto/update'  => ['DifuntoController',    'update',       'editar_difunto'],
    'difunto/delete'  => ['DifuntoController',    'delete',       'eliminar_difunto'],

    // Estado civil
    'estadoCivil'         => ['EstadoCivilController', 'index',   '__login__'],
    'estadoCivil/create'  => ['EstadoCivilController', 'create',  'crear_estado_civil'],
    'estadoCivil/save'    => ['EstadoCivilController', 'save',    'crear_estado_civil'],
    'estadoCivil/edit'    => ['EstadoCivilController', 'edit',    'editar_estado_civil'],
    'estadoCivil/update'  => ['EstadoCivilController', 'update',  'editar_estado_civil'],
    'estadoCivil/delete'  => ['EstadoCivilController', 'delete',  'eliminar_estado_civil'],

    // Parcela
    'parcela'         => ['ParcelaController','index',            '__login__'],
    'parcela/create'  => ['ParcelaController','create',           'crear_parcela'],
    'parcela/save'    => ['ParcelaController','save',             'crear_parcela'],
    'parcela/edit'    => ['ParcelaController','edit',             'editar_parcela'],
    'parcela/update'  => ['ParcelaController','update',           'editar_parcela'],
    'parcela/delete'  => ['ParcelaController','delete',           'eliminar_parcela'],

    // Sexo
    'sexo'            => ['SexoController', 'index',              '__login__'],
    'sexo/create'     => ['SexoController', 'create',             'crear_sexo'],
    'sexo/save'       => ['SexoController', 'save',               'crear_sexo'],
    'sexo/edit'       => ['SexoController', 'edit',               'editar_sexo'],
    'sexo/update'     => ['SexoController', 'update',             'editar_sexo'],
    'sexo/delete'     => ['SexoController', 'delete',             'eliminar_sexo'],

    // Pago
    'pago'            => ['PagoController', 'index',              '__login__'],
    'pago/create'     => ['PagoController', 'create',             'crear_pago'],
    'pago/save'       => ['PagoController', 'save',               'crear_pago'],
    'pago/edit'       => ['PagoController', 'edit',               'editar_pago'],
    'pago/update'     => ['PagoController', 'update',             'editar_pago'],
    'pago/delete'     => ['PagoController', 'delete',             'eliminar_pago'],

    // TipoParcela
    'tipoParcela'         => ['TipoParcelaController', 'index',   '__login__'],
    'tipoParcela/create'  => ['TipoParcelaController', 'create',  'crear_tipo_parcela'],
    'tipoParcela/save'    => ['TipoParcelaController', 'save',    'crear_tipo_parcela'],
    'tipoParcela/edit'    => ['TipoParcelaController', 'edit',    'editar_tipo_parcela'],
    'tipoParcela/update'  => ['TipoParcelaController', 'update',  'editar_tipo_parcela'],
    'tipoParcela/delete'  => ['TipoParcelaController', 'delete',  'eliminar_tipo_parcela'],

    // TipoUsuario
    'tipoUsuario'         => ['TipoUsuariosController', 'index',  'ver_tipo_usuario'],
    'tipoUsuario/create'  => ['TipoUsuariosController', 'create', 'crear_tipo_usuario'],
    'tipoUsuario/save'    => ['TipoUsuariosController', 'save',   'crear_tipo_usuario'],
    'tipoUsuario/edit'    => ['TipoUsuariosController', 'edit',   'editar_tipo_usuario'],
    'tipoUsuario/update'  => ['TipoUsuariosController', 'update', 'editar_tipo_usuario'],
    'tipoUsuario/delete'  => ['TipoUsuariosController', 'delete', 'eliminar_tipo_usuario'],

    // Deudo
    'deudo'           => ['DeudoController', 'index',             '__login__'],
    'deudo/create'    => ['DeudoController', 'create',            'crear_deudo'],
    'deudo/save'      => ['DeudoController', 'save',              'crear_deudo'],
    'deudo/edit'      => ['DeudoController', 'edit',              'editar_deudo'],
    'deudo/update'    => ['DeudoController', 'update',            'editar_deudo'],
    'deudo/delete'    => ['DeudoController', 'delete',            'eliminar_deudo'],


    // Nacionalidades
    'nacionalidades'         => ['NacionalidadesController','index', '__login__'],
    'nacionalidades/create'  => ['NacionalidadesController','create','crear_nacionalidad'],
    'nacionalidades/save'    => ['NacionalidadesController','save',  'crear_nacionalidad'],
    'nacionalidades/edit'    => ['NacionalidadesController','edit',  'editar_nacionalidad'],
    'nacionalidades/update'  => ['NacionalidadesController','update','editar_nacionalidad'],
    'nacionalidades/delete'  => ['NacionalidadesController','delete','eliminar_nacionalidad'],

    // Orientaciones
    'orientaciones'         => ['OrientacionController','index',   '__login__'],
    'orientaciones/create'  => ['OrientacionController','create',  'crear_orientacion'],
    'orientaciones/save'    => ['OrientacionController','save',    'crear_orientacion'],
    'orientaciones/edit'    => ['OrientacionController','edit',    'editar_orientacion'],
    'orientaciones/update'  => ['OrientacionController','update',  'editar_orientacion'],
    'orientaciones/delete'  => ['OrientacionController','delete',  'eliminar_orientacion'],

    // Ubicaciones
    'ubicacion'         => ['UbicacionDifuntoController','index',  '__login__'],
    'ubicacion/create'  => ['UbicacionDifuntoController','create', 'crear_ubicacion'],
    'ubicacion/save'    => ['UbicacionDifuntoController','save',   'crear_ubicacion'],
    'ubicacion/edit'    => ['UbicacionDifuntoController','edit',   'editar_ubicacion'],
    'ubicacion/update'  => ['UbicacionDifuntoController','update', 'editar_ubicacion'],
    'ubicacion/delete'  => ['UbicacionDifuntoController','delete', 'eliminar_ubicacion'],
];
// ====== Obtener ruta y metodo actual =====

// Path limpio sin querystring, o '' si no existe
if (isset($_SERVER['REQUEST_URI'])) {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Si la URI es inválida
    if ($uri === null) {  $uri = '' }

} else {  $uri = '' }   // Si no existe REQUEST_URI

// Quitar base si corresponde
if (!empty($base) && str_starts_with($uri, $base)) {
    $uri = substr($uri, strlen($base));
}

// Limpia slashes iniciales/finales
$uri = trim($uri, '/');

// Segmentar en partes (vacío → array vacío)
if ($uri === ''){
    $segments = [];
} else{
    $segments = explode('/', $uri);
}

// Método HTTP (por defecto GET si no está seteado)
if (isset($_SERVER['REQUEST_METHOD'])){
    $method = $_SERVER['REQUEST_METHOD'];
} else{
    $method = 'GET';
}

// Inicializa variables
$ruta = '';
$parametro = null;

if (count($segments) >= 2) {
    // Usamos los dos primeros como clave de ruta (p.ej. usuario/edit)
    $ruta = $segments[0] . '/' . $segments[1];
    // Si hay tercer segmento, lo tomamos como parámetro
    if (isset($segments[2])) {
        $parametro = $segments[2];
    }
} elseif (count($segments) === 1) {
    $ruta = $segments[0]; // p.ej. 'login' o 'usuario'
} else {
    $ruta = ''; // raíz → login
}

// 1️⃣​. Si la ruta está definida en el arreglo de rutas
if (!isset($routes[$ruta])) {
    echo errorMensaje('404', "Ruta '$ruta' no encontrada.");
    exit;
}
    
// 2️⃣​. Obtener el nombre del controlador, el metodo asociado a la ruta y guard.
[$controlador, $metodo, $guard] = $routes[$ruta];

// ====== Guards (auth + guards) ======
// construyo base URL para redirecciones (si tenés URL constante, úsala)
$baseUrl = rtrim(URL, '/'); // viene de config.php

if ($guard === '__login__') {
    if (!isLoggedIn()) {
        header('Location: ' . $baseUrl . '/login');
        exit;
    }
} elseif (is_string($guard) && $guard !== '__public__') {
    // String simple de guard
    requirePermission($guard, $baseUrl . '/error-guards');
} elseif (is_array($guard)) {
    // Array de guards (OR lógico en tu helper)
    requirePermission($guard, $baseUrl . '/error-guards');
}

// 3️⃣​​​​​​​​​. Armar la ruta al archivo del controlador
$archivo = __DIR__ . '/../app/controllers/' . $controlador . '.php';

// 4️⃣. Verifica si el archivo del controlador existe
if (!file_exists($archivo)) {
    echo errorMensaje('404', "Archivo del controlador no encontrado.");
    exit;
}
require_once $archivo;

// 5️⃣. Verifica si la clase existe
if (!class_exists($controlador)) {
    echo errorMensaje('404', "Controlador '$controlador' no encontrado.");
    exit;
}

// 6️⃣. Crear instancia y verificar método
$obj = new $controlador();

if (!method_exists($obj, $metodo)) {
    echo errorMensaje('405', "Método '$metodo' no existe.");
    exit;
}
    
// 7️⃣. Llamada con o sin parámetro
try {
    if ($parametro !== null) {
        $obj->$metodo($parametro);
    } else {
        $obj->$metodo();
    }

} catch (Throwable $e) {
    // 8) ​😔​ (me quedé sin stickers). Captura de emergencia
    echo errorMensaje('500', "Ups… algo salió mal: " . $e->getMessage());
    exit;
}

?>