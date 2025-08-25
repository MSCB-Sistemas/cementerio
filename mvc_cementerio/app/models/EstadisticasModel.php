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

    public function getDeudosMorosos() {
        $fecha_actual = date('Y-m-d');
        
        $stmt = $this->db->prepare("SELECT p.*, d.dni, d.nombre, d.apellido FROM pago p
                                        INNER JOIN deudo d ON p.id_deudo = d.id_deudo
                                        WHERE p.fecha_vencimiento < :fecha_actual
                                        ORDER BY p.fecha_vencimiento DESC");
        $stmt->bindParam(":fecha_actual", $fecha_actual, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDefuncionesEntreFechas($fecha_inicio, $fecha_fin, $sort_col, $sort_dir, $limite, $offset) {
        $this->establecerFechasPorDefecto($fecha_inicio, $fecha_fin);

        $columnas_permitidas = ['fecha_fallecimiento', 'nombre', 'apellido'];
        $sort_col = in_array($sort_col, $columnas_permitidas) ? $sort_col :'fecha_fallecimiento';
        $sort_dir = strtoupper($sort_dir) === 'DESC' ? 'DESC' : 'ASC';

        $stmt = $this->db->prepare("SELECT d.*, s.descripcion FROM difunto d
                                    INNER JOIN sexo s
                                    ON d.id_sexo = s.id_sexo
                                    WHERE DATE(fecha_fallecimiento) 
                                    BETWEEN :inicio AND :fin
                                    ORDER BY $sort_col $sort_dir
                                    LIMIT :limite OFFSET :offset");

        $stmt->bindValue(':inicio', $fecha_inicio);
        $stmt->bindValue(':fin', $fecha_fin);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalDefuncionesEntreFechas($fecha_inicio, $fecha_fin) {
        try {
            $this->establecerFechasPorDefecto($fecha_inicio, $fecha_fin);

            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM difunto 
                                        WHERE DATE(fecha_fallecimiento) 
                                        BETWEEN :inicio AND :fin");

            $stmt->bindValue(':inicio', $fecha_inicio);
            $stmt->bindValue(':fin', $fecha_fin);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return isset($resultado['total']) ? (int)$resultado['total'] : 0;

        } catch (PDOException $e) {
            error_log("Error en getTotalDefuncionesEntreFechas: " . $e->getMessage());
            return 0;
        }
    }

    public function getParcelasVendidas($fecha_inicio, $fecha_fin) {
        $this->establecerFechasPorDefecto($fecha_inicio, $fecha_fin);

        try {
            $stmt = $this->db->prepare("
                SELECT p.id_parcela, d.nombre, d.apellido, d.dni, pgo.total as monto, pgo.fecha_pago as fecha_venta, pgo.fecha_vencimiento
                FROM pago pgo
                INNER JOIN parcela p ON pgo.id_parcela = p.id_parcela
                INNER JOIN deudo d ON pgo.id_deudo = d.id_deudo
                WHERE DATE(pgo.fecha_pago) BETWEEN :inicio AND :fin
                ORDER BY pgo.fecha_pago DESC
            ");

            $stmt->bindValue(':inicio', $fecha_inicio);
            $stmt->bindValue(':fin', $fecha_fin);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en getParcelasVendidas: " . $e->getMessage());
            return [];
        }
    }

}

?>