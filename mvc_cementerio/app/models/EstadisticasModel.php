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
        $this->establecerFechasPorDefecto($fecha_inicio, $fecha_fin);

        $stmt = $this->db->prepare("SELECT * FROM difunto 
                                    WHERE DATE(fecha_fallecimiento) 
                                    BETWEEN :inicio AND :fin");

        $stmt->bindValue(':inicio', $fecha_inicio);
        $stmt->bindValue(':fin', $fecha_fin);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$resultado['total'];
    }
}

?>