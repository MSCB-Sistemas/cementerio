<?php
class EstadisticasController extends Control {
    private EstadisticasModel $model;

    public function __construct()
    {
        $this->requireLogin();
        $this->model = $this->loadModel("EstadisticasModel");
    }

    public function index()
    {
        $fecha_inicio = $_GET['fecha_inicio'] ?? $_GET['fecha_defuncion_inicio'] ?? '1900-01-01';
        $fecha_fin   = $_GET['fecha_fin']   ?? $_GET['fecha_defuncion_fin']    ?? date('Y-m-d');

        $fecha_inicio_traslado = $_GET['fecha_inicio_traslado'] ?? $_GET['fecha_traslado_inicio'] ?? '1900-01-01';
        $fecha_fin_traslado   = $_GET['fecha_fin_traslado']   ?? $_GET['fecha_traslado_fin']    ?? date('Y-m-d');

        $letra_apellido_difunto = $_GET['letra_apellido_difunto'] ?? '';
        $letra_apellido_deudo   = $_GET['letra_apellido_deudo'] ?? '';
        $letra_apellido_traslado = $_GET['letra_apellido_traslado'] ?? '';

       
        $sort_col = $_GET['sort_col'] ?? 'fecha_fallecimiento';
        $sort_dir = strtoupper($_GET['sort_dir'] ?? 'ASC');
        if (!in_array($sort_dir, ['ASC', 'DESC'])) {
            $sort_dir = 'ASC';
        }

        $validarFecha = function($d) {
            if (empty($d)) return false;
            $dt = DateTime::createFromFormat('Y-m-d', $d);
            return $dt && $dt->format('Y-m-d') === $d;
        };

        if (!$validarFecha($fecha_inicio)) $fecha_inicio = '1900-01-01';
        if (!$validarFecha($fecha_fin))   $fecha_fin = date('Y-m-d');
        if (!$validarFecha($fecha_inicio_traslado)) $fecha_inicio_traslado = '1900-01-01';
        if (!$validarFecha($fecha_fin_traslado))   $fecha_fin_traslado = date('Y-m-d');

       
        $pagina = !empty($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
        $limite = 14;
        $offset = ($pagina - 1) * $limite;

        
        $defunciones = $this->model->getDefuncionesEntreFechas(
            $fecha_inicio,
            $fecha_fin,
            $letra_apellido_difunto,
            $sort_col,
            $sort_dir,
            $limite,
            $offset
        );

        $deudores_morosos = $this->model->getDeudosMorosos();

        
        $filtros_parcela = [
            'tipo_parcela' => $_GET['tipo_parcela'] ?? '',
            'seccion' => $_GET['seccion'] ?? '',
            'fraccion' => $_GET['fraccion'] ?? '',
            'nivel' => $_GET['nivel'] ?? '',
            'orientacion' => $_GET['orientacion'] ?? '',
            'hilera' => $_GET['hilera'] ?? '',
            'ubicacion' => $_GET['ubicacion'] ?? ''
        ];
        $uso_filtro_parcela = array_filter($filtros_parcela);

        if ($uso_filtro_parcela) {
            $parcelas_vendidas = $this->model->getParcelasVendidasPorDatosParcela($filtros_parcela);
            $total_parcelas_vendidas = count($parcelas_vendidas);
        } else {
            $parcelas_vendidas = $this->model->getParcelasVendidas($fecha_inicio, $fecha_fin, $letra_apellido_deudo);
            $total_parcelas_vendidas = count($parcelas_vendidas);
        }

       
        $difuntos_trasladados = $this->model->getDifuntosTrasladados(
            $fecha_inicio,
            $fecha_fin,
            $fecha_inicio_traslado,
            $fecha_fin_traslado,
            $letra_apellido_traslado,
            $sort_col,
            $sort_dir,
            $limite,
            $offset
        );

        $total_difuntos = $this->model->getTotalDifuntos();
        $total_defunciones = $this->model->getTotalDefuncionesEntreFechas($fecha_inicio, $fecha_fin, $letra_apellido_difunto);
        $total_parcelas = $this->model->getTotalParcelasOcupadas();
        $total_traslados = $this->model->getTotalTraslados();
        $total_paginas = max(1, ceil($total_defunciones / $limite));

        $datos = [
            'title' => 'Estadisticas',
            'movimientos' => $defunciones,
            'deudores_morosos' => $deudores_morosos,
            'difuntos_trasladados' => $difuntos_trasladados,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'sort_col' => $sort_col,
            'sort_dir' => $sort_dir,
            'pagina_actual' => $pagina,
            'total_paginas' => $total_paginas,
            'total_resultados' => $total_defunciones,
            'total_morosos' => count($deudores_morosos),
            'parcelas_vendidas' => $parcelas_vendidas,
            'total_parcelas_vendidas' => $total_parcelas_vendidas,
            'letra_apellido_difunto' => $letra_apellido_difunto,
            'letra_apellido_deudo' => $letra_apellido_deudo,
            'letra_apellido_traslado' => $letra_apellido_traslado,
            'fecha_inicio_traslado' => $fecha_inicio_traslado,
            'fecha_fin_traslado' => $fecha_fin_traslado,
            'total_difuntos' => $total_difuntos,
            'total_parcelas' => $total_parcelas,
            'total_traslados' => $total_traslados,
            'total_defunciones' => $total_defunciones,
            'fecha_defuncion_inicio' => $fecha_inicio,
            'fecha_defuncion_fin' => $fecha_fin,
        ];

        $this->loadView("estadisticas", $datos);
    }

}
?>