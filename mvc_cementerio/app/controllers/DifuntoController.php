<?php
class DifuntoController extends Control
{
    private DifuntoModel $model;
    private DeudoModel $deudoModel;

    public function __construct()
    {
        $this->model = $this->loadModel("DifuntoModel");
        $this->deudoModel = $this->loadModel("DeudoModel");
    }

    public function index() {
        $difuntos = $this->model->getAllDifuntos();

        $datos = [
            'title' => 'Lista de difuntos',
            'urlCrear' => URL . '/difunto/create',
            'columnas' => ['ID', 'Deudo', 'Nombre', 'Apellido', 'DNI', 'Edad', 'Fecha fallecimiento', 'Genero', 'Nacionalidad', 'Estado civil', 'Domicilio', 'Localidad', 'Codigo postal'],
            'columnas_claves' => ['id_difunto', 'nombre_deudo', 'nombre', 'apellido', 'dni', 'edad', 'fecha_fallecimiento', 'sexo', 'nacionalidad', 'estado_civil', 'domicilio', 'localidad', 'codigo_postal'],
            'data' => $difuntos,
            'acciones' => function ($fila) {
                $id = $fila['id_difunto'];
                $url = URL . '/difunto';
                return '
                    <a href="' . $url . '/edit/' . $id . '" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="' . $url . '/delete/' . $id . '" class="btn btn-sm btn-outline-primary">Eliminar</a>
                ';
            },
            'errores' => [],
        ];

        $this->loadView('difuntos/DifuntoView', $datos);
    }
}
?>