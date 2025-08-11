<?php
class ParcelaController extends Control {
    private ParcelaModel $model;

    public function __construct() {
        $this->model = $this->loadModel("ParcelaModel");
    }

    public function index() {
        $parcela = $this->model->getAllParcelas();

        $datos = [
            'title' => 'Lista de parcelas',
            'urlCrear' => URL . '/parcela/create',
            'columnas' => ['ID', 'Tipo', 'Deudo', 'Hilera', 'Seccion', 'Fraccion', 'Nivel', 'Orientacion'],
            'columnas_claves' => ['id_parcela', 'id_tipo', 'hilera', 'seccion', 'fraccion', 'nivel', 'id_orientacion'],
            'acciones' => function ($fila) {
                $id = $fila['id_parcela'];
                $url = URL . '/parcela';
                return '
                ';
            },
            'errores' => [],
            'data' => $parcela
        ];

        $this->loadView('partials/tablaAbm', $datos);
    }
}
?>