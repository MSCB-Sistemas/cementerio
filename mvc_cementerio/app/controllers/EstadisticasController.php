<?php
class EstadisticasController extends Control {
    private $model;

    public function __construct() {
        $this->requireLogin();
        $this->model = $this->loadModel("EstadisticasModel");
    }

    public function index() {
        $fecha_inicio = !empty($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '2000-01-01';
        $fecha_fin = !empty($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-d');
        $letra_apellido_difunto = $_GET['letra_apellido_difunto'] ?? '';
        $letra_apellido_deudo = $_GET['letra_apellido_deudo'] ?? '';


        $sort_col = $_GET['sort_col'] ?? 'fecha_defuncion';
        $sort_dir = (isset($_GET['sort_dir']) && strtoupper($_GET['sort_dir']) === 'DESC') ? 'DESC' : 'ASC';


        $pagina = !empty($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
        $limite = 14;
        $offset = ($pagina - 1) * $limite;

        $defunciones = $this->model->getDefuncionesEntreFechas(
            $fecha_inicio, $fecha_fin, $letra_apellido_difunto, $sort_col, $sort_dir, $limite, $offset
        );

        $total_defunciones = $this->model->getTotalDefuncionesEntreFechas(
            $fecha_inicio, $fecha_fin, $letra_apellido_difunto
        );

        $deudores_morosos = $this->model->getDeudosMorosos();

        $total_defunciones = $this->model->getTotalDefuncionesEntreFechas($fecha_inicio, $fecha_fin);
        $total_paginas = max(1, ceil($total_defunciones / $limite));

        // Capturar posibles filtros de parcela
        $filtros_parcela = [
            'tipo_parcela' => $_GET['tipo_parcela'] ?? '',
            'seccion' => $_GET['seccion'] ?? '',
            'fraccion' => $_GET['fraccion'] ?? '',
            'nivel' => $_GET['nivel'] ?? '',
            'orientacion' => $_GET['orientacion'] ?? '',
            'hilera' => $_GET['hilera'] ?? '',
            'ubicacion' => $_GET['ubicacion'] ?? ''
        ];

        // Ver si se usó al menos un filtro de parcela
        $uso_filtro_parcela = array_filter($filtros_parcela);

        if ($uso_filtro_parcela) {
            // Si se usó el filtro por datos de parcela
            $parcelas_vendidas = $this->model->getParcelasVendidasPorDatosParcela($filtros_parcela);
            $total_parcelas_vendidas = $parcelas_vendidas; // No es paginado
        } else {
            // Si no, usar búsqueda por fecha o apellido
            $parcelas_vendidas = $this->model->getParcelasVendidas($fecha_inicio, $fecha_fin, $letra_apellido_deudo);
            $total_parcelas_vendidas = $this->model->getParcelasVendidas($fecha_inicio, $fecha_fin);
        }

        $datos = [
            'title' => 'Estadisticas',
            'datos_difuntos' => $defunciones,
            'deudores_morosos' => $deudores_morosos,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'sort_col' => $sort_col,
            'sort_dir' => $sort_dir,
            'pagina_actual' => $pagina,
            'total_paginas' => max(1, ceil($total_defunciones / $limite)),
            'total_resultados' => $total_defunciones,
            'total_morosos' => count($deudores_morosos),
            'parcelas_vendidas' => $parcelas_vendidas,
            'total_parcelas_vendidas' => $total_parcelas_vendidas,
            'letra_apellido_difunto' => $letra_apellido_difunto,
            'letra_apellido_deudo' => $letra_apellido_deudo,
        ];

        $this->loadView("estadisticas", $datos);
    }
}
?>