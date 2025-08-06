<?php
class DeudoController extends Control {
    private DeudoModel $model;

    function __construct()
    {
        $this->model = $this->loadModel("DeudoModel");
    }

    function index()
    {
        $deudos = $this->model->getAllDeudos();
        $datos = [
            "title" => "Lista de Deudos",
            'columnas' => ['ID', 'Nombre', 'Apellido', 'DNI', 'Teléfono', 'Email', 'Domicilio'],
            'columnas_claves' => ['id_deudo', 'nombre', 'apellido', 'dni', 'telefono', 'email', 'domicilio'],
            "acciones" => function ($fila) {
                $id = $fila['id_deudo'];
                $url = URL . '/deudo';
                return '
                <a href="' . $url . '/create/' . $id . ' "class="btn btn-sm btn-outline-primary">Crear</a>
                <a href="' . $url . '/edit/' . $id . '" class="btn btn-sm btn-outline-primary">Editar</a>
                <a href="' . $url . '/delete/' . '" class="btn btn-sm btn-outline-primary">Eliminar</a>
                ';
            },
            "errores" => [],
            "data"=> $deudos
        ];

        $this->loadView("deudos/DeudoView", $datos);
    }

    function create() {
        $deudos = $this->model->getAllDeudos();
        $datos = [
            'title'=> 'Crear Deudo',
            'action' => URL . '/deudo/save',
            'values' => [],
            'errores' => [],
            'deudos' => $deudos
        ];

        $this->loadView('deudos/DeudoForm', $datos);
    }

    function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dni = trim($_POST['dni']);
            $nombre = trim($_POST['nombre']);
            $apellido = trim($_POST['apellido']);
            $telefono = trim($_POST['telefono']);
            $email = trim($_POST['email']);
            $domicilio = trim($_POST['domicilio']);
            $localidad = trim($_POST['localidad']);
            $codigo_postal = trim($_POST['codigo_postal']);

            $errores = [];
            if (empty($dni)) { $errores[] = "El DNI es obligatorio."; }
            if (empty($nombre)) { $errores[] = "Tenes que ingresar un nombre."; }
            if (empty($apellido)) { $errores[] = "Tenes que ingresar un apellido."; }
            if (empty($telefono)) { $errores[] = "Tenes que ingresar un telefono de referencia."; }
            if (empty($email)) { $errores[] = "Ingresa un mail."; }
            if (empty($domicilio)) { $errores[] = "Tiene que ingresar un domicilio."; }
            if (empty($localidad)) { $errores[] = "Tiene que ingresar una localidad."; }
            if (empty($codigo_postal)) { $errores[] = "El codigo postal es obligatorio."; }

            if (!empty($errores)) {
                $datos = [
                    'title' => 'Crear Deudo',
                    'action' => URL . '/deudo/save',
                    'values' => [
                        'dni' => $dni,
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'telefono'=> $telefono,
                        'email'=> $email,
                        'domicilio'=> $domicilio,
                        'localidad'=> $localidad,
                        'codigo_postal'=> $codigo_postal
                    ],
                    'errores' => $errores
                ];
                $this->loadView('deudos/DeudoForm', $datos);
                return;
            }

            $idDeudo = $this->model->insertDeudo($dni, $nombre, $apellido, $telefono, $email, $domicilio, $localidad, $codigo_postal);
            if ($idDeudo) {
                header('Location: ' . URL . '/deudo');
            } else {
                die ('Error al guardar el deudo');
            }

            header('Location: ' . URL . '/deudo');
        }
    }

    function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dni = trim($_POST['dni'] ?? '');
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $domicilio = trim($_POST['domicilio'] ?? '');
            $localidad = trim($_POST['localidad'] ?? '');
            $codigo_postal = trim($_POST['codigo_postal'] ?? '');

            $errores = [];
            if (empty($dni)) { $errores[] = "Tiene que ingresar un DNI"; }
            if (empty($nombre)) { $errores[] = "Tiene que ingresar un nombre"; }
            if (empty($apellido)) { $errores[] = "Tiene que ingresar un apellido"; }
            if (empty($telefono)) { $errores[] = "Tiene que ingresar un telefono"; }
            if (empty($email)) { $errores[] = "Tiene que ingresar una direccion de mail"; }
            if (empty($domicilio)) { $errores[] = "Tiene que ingresar un domicilio"; }
            if (empty($localidad)) { $errores[] = "Tiene que ingresar una localidad"; }
            if (empty($codigo_postal)) { $errores[] = "Tiene que ingresar un código postal"; }

            if (!empty($errores)) {
                $deudo = [
                    "dni"=> $dni,
                    "nombre"=>$nombre,
                    "apellido"=>$apellido,
                    "telefono"=>$telefono,
                    "email"=>$email,
                    "domicilio"=>$domicilio,
                    "localidad"=>$localidad,
                    "codigo_postal"=>$codigo_postal
                ];

                $this->loadView("deudos/DeudosForm", [
                    'title' => 'Editar Deudo',
                    'action'=> URL . '/deudo/update' . $id,
                    'values' => $deudo,
                    'errores'=> $errores
                ])
            }
        }
    }

    function delete($id) {
        $eliminado = $this->model->deleteDeudo($id);

        if (! $eliminado) {
            die ('Error al eliminar el deudo');
        }
        header("Location: " . URL . "/deudo");
        exit;
    }

    function show($id) {}
}
?>