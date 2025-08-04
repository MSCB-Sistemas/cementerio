<?php
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/errores.php';
require_once APP . '/views/inc/sidebar.php';


// ⚠️ Modificar segun el entorno necesario
$base = '/cementerio/mvc_cementerio/';



// 📋​ Rutas disponibles: ruta => [Controlador, metodo]

$routes = [
    '' => ['UsuarioController', 'index'],
    'login' => ['UsuarioController', 'login'],
    'usuario/logout' => ['UsuarioController', 'logout'],
    'usuario/update' => ['UsuarioController', 'update'],
    'usuario/mostrar' => ['UsuarioController', 'mostrar'],

    // setear tantas rutas como sean necesarias
];





// Obtener ruta y metodo actual
$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace($base, '', $uri);
$uri = trim(parse_url($uri, PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];


// Separar en partes la ruta para manejar mejor los parametros
$partes = explode('/', $uri);

// Inicializa vairables
$ruta = '';
$parametro = null;

// Logica para GET con 1 variable (ejemplo: usuario/12)
if ($method === 'GET' && count($partes) === 2) {
    $ruta = $partes[0] . '/mostrar';
    $parametro = $partes[1];
}else {
    // sino arma ruta normal
    $ruta = implode('/', $partes);
}









// 1️⃣​. Si la ruta esta definida en el arreglo de rutas
if (isset($routes[$ruta])) {
    
    // 2️⃣​. Obtener el nombre del controlador y del metodo asociado a la ruta
    $controlador = $routes[$ruta][0];
    $metodo = $routes[$ruta][1];

    // 3️⃣​​​​​​​​​. Armar la ruta al archivo del controlador
    $archivo = __DIR__ . '/../app/controllers/' . $controlador . '.php';

    // 4️⃣. Verifica si el controlador existe
    if (file_exists($archivo)) {
        require_once $archivo;

        // 5️⃣. Verifica si la clase existe
        if (class_exists($controlador)) {
            $obj = new $controlador();

            // 6️⃣. Verifica si el metodo existe
            if (method_exists($obj, $metodo)) {

                // 7️⃣. Si hay parametro se pasa
                if ($parametro !== null) {
                    $obj->$metodo($parametro);
                } 
                // 8️⃣. sino se llama al metodo sin parametros
                else {
                    $obj->$metodo();
                }
                exit;
            } 
            // 9️⃣. erro el metodo no exite
            else {
                echo errorMensaje('405', "Método '$metodo' no existe.");
            }
        } 
        // 🔟. error la clase no existe
        else {
            echo errorMensaje('404', "Controlador '$controlador' no encontrado.");
        }
    } 
    // 11 ​😔​ (me quede sin stickers). El archivo del controlador no existe
    else {
        echo errorMensaje('404', "Archivo del controlador no encontrado.");
    }
} 
// 12 😭. La ruta no esta definida
else {
    echo errorMensaje('404', "Ruta '$ruta' no encontrada.");
}

?>