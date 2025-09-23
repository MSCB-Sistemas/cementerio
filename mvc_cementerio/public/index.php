<?php
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/errores.php';
require_once __DIR__ . '/../app/lib/Control.php';

$base = '/cementerio/mvc_cementerio';

// 📋​ Rutas disponibles: ruta => [Controlador, metodo]
$routes = [

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

    // URL's traslados.
    'pagoFunc' => ['PagoFuncController', 'index'],
    'pagoFunc/save' => ['PagoFuncController', 'save'],

    // URL's difunto.
    'difunto' => ['DifuntoController', 'index'],
    'difunto/create' => ['DifuntoController', 'create'],
    'difunto/save' => ['DifuntoController', 'save'],
    'difunto/edit' => ['DifuntoController', 'edit'],
    'difunto/update' => ['DifuntoController', 'update'],
    'difunto/delete' => ['DifuntoController', 'delete'],

    // URL's estado civil.
    'estadoCivil' => ['EstadoCivilController', 'index'],
    'estadoCivil/create' => ['EstadoCivilController', 'create'],
    'estadoCivil/save' => ['EstadoCivilController', 'save'],
    'estadoCivil/edit' => ['EstadoCivilController', 'edit'],
    'estadoCivil/update' => ['EstadoCivilController', 'update'],
    'estadoCivil/delete' => ['EstadoCivilController', 'delete'],

    // URL's parcela.
    'parcela' => ['ParcelaController','index'],
    'parcela/save'=> ['ParcelaController', 'save'],
    'parcela/create'=> ['ParcelaController', 'create'],
    'parcela/edit'=> ['ParcelaController', 'edit'],
    'parcela/update'=> ['ParcelaController', 'update'],
    'parcela/delete'=> ['ParcelaController', 'delete'],
    'parcela/obtenerInfoParcela' => ['ParcelaController', 'obtenerInfoParcela'],

    // URL's sexo.
    'sexo' => ['SexoController', 'index'],
    'sexo/create' => ['SexoController', 'create'],
    'sexo/save' => ['SexoController', 'save'],
    'sexo/edit' => ['SexoController', 'edit'],
    'sexo/update' => ['SexoController', 'update'],
    'sexo/delete' => ['SexoController', 'delete'],

    // URL's pagos
    'pago' => ['PagoController', 'index'],
    'pago/create' => ['PagoController', 'create'],
    'pago/save' => ['PagoController', 'save'],
    'pago/edit' => ['PagoController', 'edit'],
    'pago/update' => ['PagoController', 'update'],
    'pago/delete' => ['PagoController', 'delete'],

    // URL's tipos de parcela.
    'tipoParcela'=> ['TipoParcelaController', 'index'],
    'tipoParcela/create'=> ['TipoParcelaController', 'create'],
    'tipoParcela/save'=> ['TipoParcelaController', 'save'],
    'tipoParcela/edit'=> ['TipoParcelaController', 'edit'],
    'tipoParcela/update'=> ['TipoParcelaController', 'update'],
    'tipoParcela/delete'=> ['TipoParcelaController', 'delete'],

    // URL's tipos de usuario.
    'tipoUsuario'=> ['TipoUsuariosController', 'index'],
    'tipoUsuario/create'=> ['TipoUsuariosController', 'create'],
    'tipoUsuario/save'=> ['TipoUsuariosController', 'save'],
    'tipoUsuario/edit'=> ['TipoUsuariosController', 'edit'],
    'tipoUsuario/update'=> ['TipoUsuariosController', 'update'],
    'tipoUsuario/delete'=> ['TipoUsuariosController', 'delete'],

    // URL's deudo.
    'deudo' => ['DeudoController', 'index'],
    'deudo/create' => ['DeudoController', 'create'],
    'deudo/save' => ['DeudoController', 'save'],
    'deudo/edit' => ['DeudoController', 'edit'],
    'deudo/update' => ['DeudoController', 'update'],
    'deudo/delete' => ['DeudoController', 'delete'],


    //URL's nacionalidades
    'nacionalidades' => ['NacionalidadesController','index'],
    'nacionalidades/create' => ['NacionalidadesController', 'create'],
    'nacionalidades/save' => ['NacionalidadesController', 'save'],
    'nacionalidades/edit' => ['NacionalidadesController', 'edit'],
    'nacionalidades/update' => ['NacionalidadesController', 'update'],
    'nacionalidades/delete' => ['NacionalidadesController', 'delete'],

    //URL's orientaciones
    'orientaciones' => ['OrientacionController', 'index'],
    'orientaciones/create' => ['OrientacionController', 'create'],
    'orientaciones/save' => ['OrientacionController', 'save'],
    'orientaciones/edit' => ['OrientacionController', 'edit'],
    'orientaciones/update' => ['OrientacionController', 'update'],
    'orientaciones/delete' => ['OrientacionController', 'delete'],

    //URL's ubicaciones
    'ubicacion' => ['UbicacionDifuntoController', 'index'],
    'ubicacion/create' => ['UbicacionDifuntoController', 'create'],
    'ubicacion/save' => ['UbicacionDifuntoController', 'save'],
    'ubicacion/edit' => ['UbicacionDifuntoController', 'edit'],
    'ubicacion/update' => ['UbicacionDifuntoController', 'update'],
    'ubicacion/delete' => ['UbicacionDifuntoController', 'delete'],
];

// Obtener ruta y metodo actual
$uri = $_SERVER['REQUEST_URI'];
// var_dump($uri);
$uri = str_replace($base, '', $uri);
$uri = trim(parse_url($uri, PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];
//var_dump($_SERVER['REQUEST_URI']);

// var_dump($method);

// Separar en partes la ruta para manejar mejor los parametros
$partes = explode('/', $uri);

// var_dump($partes);

// Inicializa vairables
$ruta = '';
$parametro = null;

// Logica para GET con 1 variable (ejemplo: usuario/12)

if (($method === 'GET' || $method === 'POST') && count($partes) === 3) {
    // var_dump($method);
    $ruta = $partes[0] . '/' . $partes[1];
    $parametro = $partes[2];
} else {
    // sino arma ruta normal
    $ruta = implode('/', $partes);
}

// var_dump($ruta);

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
            // 9️⃣. error el metodo no exite
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