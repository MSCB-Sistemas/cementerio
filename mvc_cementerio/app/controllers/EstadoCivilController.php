<?php
class EstadoCivilController extends Control {
    private EstadoCivilModel $model;

    public function __construct() {
        $this->model = $this->loadModel("EstadoCivilModel");
    }
    public function index() {
        $estadosCiviles = $this->model->getAllEstadosCiviles();

        $datos = [
            'title' => 'Lista de estados civiles',
            'urlCrear' => URL . '/estadoCivil/create',
            'columnas' => ['ID', 'Descripcion'],
            'columnas_claves' => ['id_estado_civil', 'descripcion'],
            'data' => $estadosCiviles,
            'acciones' => function ($fila) {
                $id = $fila['id_estado_civil'];
                $url = URL . 'estadoCivil';
                return '
                ';
            },
            'errores' => [],
        ];

        $this->loadView('partials/tablaAbm', $datos);
    }

    public function create() {
        $datos = [
            'title' => 'Crear estado civil',
            'action' => URL . 'estadoCivil/save',
            'values' => [],
            'errores' => [],
        ];

        $this->loadView('estado_civil/EstadoCivilForm', $datos);
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $descripcion = trim($_POST['descripcion'] ?? '');
            $errores = [];

            if (empty($descripcion)) $errores[] = "La descripcion es obligatoria.";

            if (!empty($errores)) {
                $this->loadView('estados_civiles/EstadoCivilForm', [
                    
                ]);
                return;
            }
        }
    }
}
?>