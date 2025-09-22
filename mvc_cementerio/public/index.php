<?php
// Abre sesión y carga helpers
require_once __DIR__ . '/../app/init.php';

$base = '/cementerio/mvc_cementerio';

// ====== Definición de rutas: 'ruta' => [Controller, method, guard] ======
// guards:
//   - '__public__'  => accesible sin login
//   - '__login__'   => requiere estar logueado
//   - 'guard_x'   => requiere ese guard RBAC (OR si pasas array de guards)

<<<<<<< HEAD
    // URL's usuario.
    'usuario' => ['UsuarioController', 'index'],
    'usuario/create' => ['UsuarioController', 'create'],
    'usuario/save' => ['UsuarioController', 'save'],
    'usuario/edit' => ['UsuarioController', 'edit'],
    'usuario/update' => ['UsuarioController', 'update'],
    'usuario/delete' => ['UsuarioController', 'delete'],
    'usuario/activate' => ['UsuarioController', 'activate'],
    'usuario/changePass' => ['UsuarioController', 'changePass'],
    'usuario/savePass' => ['UsuarioController', 'savePass'],
    
    // URL's login
    '' => ['AuthController', 'login'],
    'login' => ['AuthController', 'login'],
    'logout' => ['AuthController', 'logout'],
    'home' => ['HomeController', 'index'],
    'estadisticas' => ['EstadisticasController', 'index'],
=======
// Así router y sidebar (vistas) usan la misma fuente.
$routes = require __DIR__ . '/../app/config/routes.php';
>>>>>>> restriccion-user-dani

// ====== Obtener ruta y metodo actual =====

// Path limpio sin querystring, o '' si no existe
if (isset($_SERVER['REQUEST_URI'])) {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Si la URI es inválida
    if ($uri === null)   
        $uri = '';

} else {  $uri = ''; }   // Si no existe REQUEST_URI

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
$fallbackError = $baseUrl . '/error-permisos';

if ($guard === '__login__') {
    if (!isLoggedIn()) {
        header('Location: ' . $baseUrl . '/login');
        exit;
    }
} elseif (is_string($guard) && $guard !== '__public__') {
    // String simple de guard
    requirePermission($guard, $fallbackError);
} elseif (is_array($guard)) {
    // Array de guards (OR lógico en tu helper)
    requirePermission($guard, $fallbackError);
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