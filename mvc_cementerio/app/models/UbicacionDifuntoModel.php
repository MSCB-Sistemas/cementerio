<?php
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

class UbicacionDifuntoModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAllUbicaciones(): array {
        $stmt = $this->db->prepare("SELECT * FROM ubicacion_difunto");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUbicacionDifunto(int $id_ubicacion_difunto): array|false {
        $stmt = $this->db->prepare("SELECT * FROM ubicacion_difunto WHERE id_ubicacion_difunto = :id_ubicacion_difunto");
        $stmt->execute(['id_ubicacion_difunto' => $id_ubicacion_difunto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
