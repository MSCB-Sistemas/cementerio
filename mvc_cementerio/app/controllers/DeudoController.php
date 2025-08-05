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
            'title' => 'Lista de Deudos',
            'urlCrear' => URL . '/deudo/create',
            'columnas' => [
                'DNI', 'Nombre', 'Apellido', 'Teléfono', 'Email', 'Domicilio', 'Localidad', 'Código Postal'
            ],
            'columnas_claves' => [
                'dni', 'nombre', 'apellido', 'telefono', 'email', 'domicilio', 'localidad', 'codigo_postal'
            ],
            'data' => $deudos,
            'acciones' => function($fila) {
                $id = $fila['id_deudo'];
                $url = URL . '/deudo';
                return '
                    <a href="'.$url.'/edit/'.$id.'" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="'.$url.'/delete/'.$id.'" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'¿Eliminar este difunto?\');">Eliminar</a>
                ';
            }
        ];
        $this->loadView('partials/TablaView', $datos);
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

        $this->loadView('deudos/DeudoView', $datos);
    }

    function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
        }
    }

    function show($id) {
        $deudo = $this->deudo->getDeudo($id);
        if ($deudo) {
            require_once(__DIR__ . '../views/pages/deudos/DeudoDetailView.php');
        } else {
            echo errorMensaje('404', 'Deudo no encontrado.');
        }
    }
}
?>