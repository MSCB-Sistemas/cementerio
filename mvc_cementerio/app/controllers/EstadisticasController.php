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
        $fecha_inicio = !empty($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-01');
        $fecha_fin = !empty($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-d');
        $letra_apellido_difunto = $_GET['letra_apellido_difunto'] ?? '';
        $letra_apellido_deudo = $_GET['letra_apellido_deudo'] ?? '';

        $sort_col = !empty($_GET['sort_col']) ? $_GET['sort_col'] : 'fecha';
        $sort_dir = !empty($_GET['sort_dir']) && in_array($_GET['sort_dir'], ['ASC', 'DESC']);

        $sort_dir = strtoupper($_GET['sort_dir'] ?? 'ASC');
            if (!in_array($sort_dir, ['ASC', 'DESC'])) {
                $sort_dir = 'ASC';
        }


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

        $difuntos_trasladados = $this->model->getDifuntosTrasladados($sort_col, $sort_dir, $limite, $offset);

        $total_defunciones = $this->model->getTotalDefuncionesEntreFechas($fecha_inicio, $fecha_fin, $letra_apellido_difunto);
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

        $uso_filtro_parcela = array_filter($filtros_parcela);

        if ($uso_filtro_parcela) {
            // Si se usó el filtro por datos de parcela
            $parcelas_vendidas = $this->model->getParcelasVendidasPorDatosParcela($filtros_parcela);
            $total_parcelas_vendidas = count($parcelas_vendidas);
        } else {
            // Si no, usar búsqueda por fecha o apellido            
            $parcelas_vendidas = $this->model->getParcelasVendidas($fecha_inicio, $fecha_fin, $letra_apellido_deudo);
            $total_parcelas_vendidas = count($this->model->getParcelasVendidas($fecha_inicio, $fecha_fin));
        }

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
        ];

        $this->loadView("estadisticas", $datos);
    }
}
?>