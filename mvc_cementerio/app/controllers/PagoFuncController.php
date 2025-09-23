<?php
class PagoFuncController extends Control {
    private PagoFuncModel $model;

    public function __construct() {
        $this->requireLogin();
        $this->model = $this->loadModel('PagoFuncModel');
    }

    public function index($errores = []) {
        $model = $this->loadModel('PagoFuncModel');
        $traslados = $model->getAllTraslados();

        $parcelas = $this->loadModel('ParcelaModel')->getAllParcelas();
        $deudos = $this->loadModel('DeudoModel')->getAllDeudos();
        $difuntos = $this->loadModel('DifuntoModel')->getAllDifuntos();

        $datos = [
            'title' => 'Generar pago',
            'data' => $traslados,
            'action' => URL . 'pagoFunc/save',
            'parcelas' => $parcelas,
            'deudos' => $deudos,
            'difuntos' => $difuntos,
            'errores' => $errores
        ];

        $this->loadView('pagoFunc/PagoForm', $datos );
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errores = [];

            $id_difunto = $_POST['id_difunto'] ?? '';
            $id_parcela = $_POST['id_parcela'] ?? '';
            $id_deudo = $_POST['id_deudo'] ?? '';
            $fecha_traslado = $_POST['fecha_traslado'] ?? '';
            $fecha_vencimiento = $_POST['fecha_vencimiento'] ?? '';

            if (empty($id_difunto)) $errores[] = 'Seleccione un difunto';
            if (empty($id_parcela)) $errores[] = 'Seleccione una parcela';
            if (empty($id_deudo)) $errores[] = 'Seleccione un deudo';
            if (empty($fecha_vencimiento)) $errores[] = 'Ingrese la fecha de vencimiento';

            if (empty($errores)) {
                $model = $this->loadModel('PagoFuncModel');

                if ($model->verificarParcelaOcupada($id_parcela)) {
                    $errores[] = 'La parcela seleccionada ya está ocupada';
                } else {
                    $ubicacion_actual = $model->obtenerUbicacionActual($id_difunto);

                    if ($ubicacion_actual && isset($ubicacion_actual['id_pago'])) {
                        $model->actualizarVencimientoPago($ubicacion_actual['id_pago'], $fecha_traslado);
                    }

                    $total = 1000; // Monto fijo para el ejemplo, deberiamos poder seleccionarlo desde el form, tarea para galo del futuro.

                    $nuevo_pago_id = $model->crearNuevoPago(
                        $id_deudo,
                        $id_parcela,
                        $fecha_traslado,
                        $fecha_vencimiento,
                        $total
                    );

                    if ($nuevo_pago_id) {
                        if ($model->realizarTraslado($id_difunto, $id_parcela, $fecha_traslado)) {
                            header('Location: ' . URL . '/pagoFunc');
                            exit;
                        }
                    }

                    $errores[] = 'Error al realizar el traslado. Intente nuevamente.';
                }
            }
        }

        $this->index($errores);
    }

    public function infoDifunto() {
        $id_difunto = $_GET['id_difunto'] ?? null;
        $html = '<p class="text-muted">Sin información</p>';

        if ($id_difunto) {
            $model = $this->loadModel('PagoFuncModel');
            $historial = $model->obtenerHistorialTraslados($id_difunto);
            $ubicacion = $model->obtenerUbicacionActual($id_difunto);

            ob_start();
            if ($ubicacion) {
                echo '<div class="alert alert-info">Ubicación actual: Parcela ' . htmlspecialchars($ubicacion['id_parcela']) . '</div>';
            }
            if ($historial) {
                echo '<ul class="list-group mt-2">';
                foreach ($historial as $h) {
                    echo '<li class="list-group-item">Traslado a parcela ' . $h['id_parcela'] . ' en ' . $h['fecha'] . '</li>';
                }
                echo '</ul>';
            }
            $html = ob_get_clean();
        }

        echo json_encode(['html' => $html]);
    }

    
    public function infoParcela() {
        $id_parcela = $_GET['id_parcela'] ?? null;
        $html = '<p class="text-muted">Sin información</p>';
    
        if ($id_parcela) {
            $model = $this->loadModel('PagoFuncModel');
            $ocupada = $model->verificarParcelaOcupada($id_parcela);
            $pagos = $model->obtenerPagosPorParcela($id_parcela);
    
            ob_start();
            if ($ocupada) {
                echo '<div class="alert alert-danger">Parcela ocupada. ';
            } else {
                echo '<div class="alert alert-success">Parcela disponible</div>';
            }

            if ($pagos) {
                echo '<div class="table-responsive mt-2"><table class="table table-sm">';
                echo '<thead><tr><th>ID Pago</th><th>Vencimiento</th><th>Monto</th><th>Estado</th></tr></thead><tbody>';
                foreach ($pagos as $p) {
                    echo '<tr>';
                    echo '<td>' . $p['id_pago'] . '</td>';
                    echo '<td>' . $p['fecha_vencimiento'] . '</td>';
                    echo '<td>' . $p['monto'] . '</td>';
                    echo '<td>' . ($p['pagado'] ? 'Pagado' : 'Pendiente') . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table></div>';
            }
            $html = ob_get_clean();
        }
    
        echo json_encode(['html' => $html]);
    }
    
}
?>