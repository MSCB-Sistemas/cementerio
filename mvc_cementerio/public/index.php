<?php
require_once __DIR__ . '/../app/config/errores.php';


// ⚠️ Modificar segun el entorno necesario
$base = '/cementerio/mvc_cementerio/';



// 📋​ Rutas disponibles: ruta => [Controlador, método]

$routes = [
    '' => ['UsuarioController', 'index'],
    'login' => ['UsuarioController', 'login'],
    'usuario/logout' => ['UsuarioController', 'logout'],
    'usuario/update' => ['UsuarioController', 'update'],
    'usuario/mostrar' => ['UsuarioController', 'mostrar'],
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

// Lógica para GET con 1 variable (ej: usuario/12)
if ($method === 'GET' && count($partes) === 2) {
    $ruta = $partes[0] . '/mostrar';
    $parametro = $partes[1];
}else {
    // sino arma ruta normal
    $ruta = implode('/', $partes);
}









// 1️⃣​. Si la ruta está definida en el arreglo de rutas
if (isset($routes[$ruta])) {
    
    // 2️⃣​. Obtener el nombre del controlador y del método asociado a la ruta
    $controlador = $routes[$ruta][0];
    $metodo = $routes[$ruta][1];

    // 3️⃣​​​​​​​​​. Armar la ruta al archivo del controlador
    $archivo = __DIR__ . '/../app/controllers/' . $controlador . '.php';

    // 4️⃣. Verificar si el archivo del controlador existe
    if (file_exists($archivo)) {
        require_once $archivo;

        // 5️⃣. Verificar si la clase del controlador existe
        if (class_exists($controlador)) {
            $obj = new $controlador();

            // 6️⃣. Verificar si el método existe en el controlador
            if (method_exists($obj, $metodo)) {

                // 7️⃣. Si hay un parámetro, lo pasa al método
                if ($parametro !== null) {
                    $obj->$metodo($parametro);
                } 
                // 8️⃣. Si no hay parámetro, llama al método sin argumentos
                else {
                    $obj->$metodo();
                }
                exit;
            } 
            // 9️⃣. El método no existe
            else {
                echo errorMensaje('405', "Método '$metodo' no existe.");
            }
        } 
        // 🔟. La clase del controlador no existe
        else {
            echo errorMensaje('404', "Controlador '$controlador' no encontrado.");
        }
    } 
    // 11 ​😔​ (me quede sin stikers). El archivo del controlador no existe
    else {
        echo errorMensaje('404', "Archivo del controlador no encontrado.");
    }
} 
// 12 😭. La ruta no está definida
else {
    echo errorMensaje('404', "Ruta '$ruta' no encontrada.");
}

?>