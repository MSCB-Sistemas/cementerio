<?php
class EstadisticasController extends Control {
    private $model;

    public function __construct() {
        $this->requireLogin();
        $this->model = $this->loadModel("EstadisticasModel");
    }

    public function index() {
        $fecha_inicio = '';
        $fecha_fin = '';
        $fecha_inicio_resumen = '2000-01-01';
        $fecha_fin_resumen = date('Y-m-d');

        if (!empty($_GET['fecha_inicio'])) $fecha_inicio = $_GET['fecha_inicio'];
        if (!empty($_GET['fecha_fin'])) $fecha_fin = $_GET['fecha_fin'];
        if (!empty($_GET['fecha_inicio_resumen'])) $fecha_inicio_resumen = $_GET['fecha_inicio_resumen'];
        if (!empty($_GET['fecha_fin_resumen'])) $fecha_fin_resumen = $_GET['fecha_fin_resumen'];

        $sort_col = 'fecha';

        if (!empty($_GET['sort_col'])){
            $sort_col = $_GET['sort_col'];
        }

        $sort_dir = 'ASC';

        if (!empty($_GET['sort_dir']) && in_array($sort_dir, ['ASC', 'DESC'])) {
            $sort_dir = strtoupper($_GET['sort_dir']);
        }

        $pagina = 1;

        if (!empty($_GET['pagina'])) $pagina = max(1, (int)$_GET['pagina']);

        $limite = 10;
        $offset = ($pagina - 1) * $limite;

        $resultados = $this->model->getDefuncionesEntreFechas($fecha_inicio, $fecha_fin);
        $total_paginas = max(1, ceil($resultados / $limite));

        $datos = [
            'title' => 'Estadisticas',
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'sort_col' => $sort_col,
            'sort_dir' => $sort_dir,
            'pagina_actual' => $pagina,
            'total_paginas' => $total_paginas,
            'total_resultados' => $resultados
        ];

        $this->loadView("estadisticas", $datos);
    }
}
?>