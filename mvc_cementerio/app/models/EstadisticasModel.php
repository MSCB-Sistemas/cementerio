<?php
require_once __DIR__ . '/../config/config.php';
require_once 'Database.php';

class EstadisticasModel extends Control {
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    private function establecerFechasPorDefecto(&$fecha_inicio, &$fecha_fin)
    {
        if (!$fecha_fin) {
            $fecha_fin = date('Y-m-d');
        }

        if (!$fecha_inicio) {
            $fecha_inicio = date('Y-m-d', strtotime('-30 days', strtotime($fecha_fin)));
        }
    }

    public function getDeudosMorosos()
    {
        $fecha_actual = date('Y-m-d');

        $stmt = $this->db->prepare("SELECT p.*, d.dni, d.nombre, d.apellido FROM pago p
                                        INNER JOIN deudo d ON p.id_deudo = d.id_deudo
                                        WHERE p.fecha_vencimiento < :fecha_actual
                                        ORDER BY p.fecha_vencimiento DESC");
        $stmt->bindParam(":fecha_actual", $fecha_actual, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDefuncionesEntreFechas($fecha_inicio, $fecha_fin, $letra_apellido, $sort_col, $sort_dir, $limite, $offset) {
        $this->establecerFechasPorDefecto($fecha_inicio, $fecha_fin);

        $columnas_permitidas = ['fecha_fallecimiento', 'nombre', 'apellido'];
        $sort_col = in_array($sort_col, $columnas_permitidas) ? $sort_col :'fecha_fallecimiento';
        $sort_dir = strtoupper($sort_dir) === 'DESC' ? 'DESC' : 'ASC';

        $sql = "SELECT d.*, 
               s.descripcion AS sexo, 
               n.nacionalidad AS nacionalidad,
               ec.descripcion AS estado_civil,
               CONCAT(deu.nombre, ' ', deu.apellido) AS deudo
        FROM difunto d
        INNER JOIN sexo s ON d.id_sexo = s.id_sexo
        LEFT JOIN nacionalidades n ON d.id_nacionalidad = n.id_nacionalidad
        LEFT JOIN estado_civil ec ON d.id_estado_civil = ec.id_estado_civil
        LEFT JOIN deudo deu ON d.id_deudo = deu.id_deudo
        WHERE DATE(d.fecha_fallecimiento) BETWEEN :inicio AND :fin";

        if (!empty($letra_apellido)) {
            $sql .= " AND d.apellido LIKE :letra_apellido";
        }

        $sql .= " ORDER BY $sort_col $sort_dir LIMIT :limite OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':inicio', $fecha_inicio);
        $stmt->bindValue(':fin', $fecha_fin);
        if (!empty($letra_apellido)) {
            $stmt->bindValue(':letra_apellido', $letra_apellido . '%');
        }
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

    public function getTotalDefuncionesEntreFechas($fecha_inicio, $fecha_fin, $letra_apellido = '') {
        try {
            $this->establecerFechasPorDefecto($fecha_inicio, $fecha_fin);

            $sql = "SELECT COUNT(*) as total FROM difunto 
                    WHERE DATE(fecha_fallecimiento) BETWEEN :inicio AND :fin";

            if (!empty($letra_apellido)) {
                $sql .= " AND apellido LIKE :letra_apellido";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':inicio', $fecha_inicio);
            $stmt->bindValue(':fin', $fecha_fin);

            if (!empty($letra_apellido)) {
                $stmt->bindValue(':letra_apellido', $letra_apellido . '%');
            }

            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return isset($resultado['total']) ? (int)$resultado['total'] : 0;

        } catch (PDOException $e) {
            error_log("Error en getTotalDefuncionesEntreFechas: " . $e->getMessage());
            return 0;
        }   
    }

    public function getParcelasVendidas($fecha_inicio, $fecha_fin, $letra_apellido = '') {
        $this->establecerFechasPorDefecto($fecha_inicio, $fecha_fin);

        try {
            $sql = "
                SELECT p.id_parcela, d.nombre, d.apellido, d.dni, pgo.total as monto, pgo.fecha_pago as fecha_venta, pgo.fecha_vencimiento
                FROM pago pgo
                INNER JOIN parcela p ON pgo.id_parcela = p.id_parcela
                INNER JOIN deudo d ON pgo.id_deudo = d.id_deudo
                WHERE DATE(pgo.fecha_pago) BETWEEN :inicio AND :fin
            ";

            if (!empty($letra_apellido)) {
                $sql .= " AND d.apellido LIKE :letra_apellido";
            }

            $sql .= " ORDER BY pgo.fecha_pago DESC";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(':inicio', $fecha_inicio);
            $stmt->bindValue(':fin', $fecha_fin);

            if (!empty($letra_apellido)) {
                $stmt->bindValue(':letra_apellido', $letra_apellido . '%');
            }

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error en getParcelasVendidas: " . $e->getMessage());
            return [];
        }
    }

    public function getParcelasVendidasPorDatosParcela($filtros = []) {
    try {
        $sql = "
            SELECT p.id_parcela, d.nombre, d.apellido, d.dni, pgo.total as monto, pgo.fecha_pago as fecha_venta, pgo.fecha_vencimiento
            FROM pago pgo
            INNER JOIN parcela p ON pgo.id_parcela = p.id_parcela
            INNER JOIN deudo d ON pgo.id_deudo = d.id_deudo
            WHERE 1=1
        ";

        $params = [];

        if (!empty($filtros['tipo_parcela'])) {
            $sql .= " AND p.tipo = :tipo_parcela";
            $params[':tipo_parcela'] = $filtros['tipo_parcela'];
        }

        if (!empty($filtros['seccion'])) {
            $sql .= " AND p.seccion = :seccion";
            $params[':seccion'] = $filtros['seccion'];
        }

        if (!empty($filtros['fraccion'])) {
            $sql .= " AND p.fraccion = :fraccion";
            $params[':fraccion'] = $filtros['fraccion'];
        }

        if (!empty($filtros['nivel'])) {
            $sql .= " AND p.nivel = :nivel";
            $params[':nivel'] = $filtros['nivel'];
        }

        if (!empty($filtros['orientacion'])) {
            $sql .= " AND p.orientacion = :orientacion";
            $params[':orientacion'] = $filtros['orientacion'];
        }

        if (!empty($filtros['hilera'])) {
            $sql .= " AND p.hilera = :hilera";
            $params[':hilera'] = $filtros['hilera'];
        }

        if (!empty($filtros['ubicacion'])) {
            $sql .= " AND p.ubicacion = :ubicacion";
            $params[':ubicacion'] = $filtros['ubicacion'];
        }

        $sql .= " ORDER BY pgo.fecha_pago DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Error en getParcelasVendidasPorDatosParcela: " . $e->getMessage());
        return [];
    }
}

    public function getDifuntosTrasladados($sort_col, $sort_dir, $limite, $offset){
        $columnas_permitidas = ['nombre', 'apellido', 'fecha_fallecimiento', 'fecha_retiro'];
        $sort_col = in_array($sort_col, $columnas_permitidas) ? $sort_col :'fecha_retiro';
        $sort_dir = strtoupper($sort_dir) === 'DESC' ? 'DESC' : 'ASC';
        $stmt = $this->db->prepare("SELECT d.*, d.dni, d.nombre, d.apellido, d.fecha_fallecimiento, u.fecha_retiro
                                     FROM difunto d 
                                     INNER JOIN ubicacion_difunto u
                                     ON  d.id_difunto = u.id_difunto
                                     WHERE u.fecha_retiro != '0000-00-00'
                                     ORDER BY $sort_col $sort_dir
                                     LIMIT :limite OFFSET :offset
                                     ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();     
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);                                     
    }
}

?>