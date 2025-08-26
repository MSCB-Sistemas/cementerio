<?php
class EstadisticasController extends Control {
    private $model;

    public function __construct() {
        $this->requireLogin();
        $this->model = $this->loadModel("EstadisticasModel");
    }

    public function index() {
        $fecha_inicio = !empty($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-01');
        $fecha_fin = !empty($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-d');

        $sort_col = !empty($_GET['sort_col']) ? $_GET['sort_col'] : 'fecha';
        $sort_dir = !empty($_GET['sort_dir']) && in_array($_GET['sort_dir'], ['ASC', 'DESC']);

        $pagina = !empty($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
        $limite = 14;
        $offset = ($pagina - 1) * $limite;

        $defunciones = $this->model->getDefuncionesEntreFechas(
            $fecha_inicio, $fecha_fin, $sort_col, $sort_dir, $limite, $offset
        );

        $deudores_morosos = $this->model->getDeudosMorosos();

        $total_defunciones = $this->model->getTotalDefuncionesEntreFechas($fecha_inicio, $fecha_fin);
        $total_paginas = max(1, ceil($total_defunciones / $limite));

        $datos = [
            'title' => 'Estadisticas',
            'movimientos' => $defunciones,
            'deudores_morosos' => $deudores_morosos,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'sort_col' => $sort_col,
            'sort_dir' => $sort_dir,
            'pagina_actual' => $pagina,
            'total_paginas' => $total_paginas,
            'total_resultados' => $total_defunciones,
            'total_morosos' => count($deudores_morosos)
        ];

        $this->loadView("estadisticas", $datos);
    }
}
?>