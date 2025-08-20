<?php
require_once __DIR__ . '/../config/config.php';
require_once 'Database.php';

class EstadisticasModel extends Control {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    private function establecerFechasPorDefecto(&$fecha_inicio, &$fecha_fin) {
        if (!$fecha_fin) {
            $fecha_fin = date('Y-m-d');
        }

        if (!$fecha_inicio) {
            $fecha_inicio = date('Y-m-d', strtotime('-30 days', strtotime($fecha_fin)));
        }
    }

    public function getDefuncionesEntreFechas($fecha_inicio = null, $fecha_fin = null) {
        $this->establecerFechasPorDefecto($fecha_inicio, $fecha_fin);

        $stmt = $this->db->prepare('SELECT * FROM difunto 
                                    WHERE DATE(fecha_fallecimiento) 
                                    BETWEEN :inicio AND :fin');
        $stmt->bindValue(':inicio', $fecha_inicio);
        $stmt->bindValue(':fin', $fecha_fin);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($resultado['defunciones_por_fecha'])) {
            return 0;
        }
        return $resultado['defunciones_por_fecha'];
    }
}

?>