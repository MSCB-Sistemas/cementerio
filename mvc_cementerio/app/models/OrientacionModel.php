<?php
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

class OrientacionModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAllOrientaciones(): array {
        $stmt = $this->db->prepare("SELECT * FROM orientacion");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrientacion(int $id_orientacion): array|false {
        $stmt = $this->db->prepare("SELECT * FROM orientacion WHERE id_orientacion = :id_orientacion");
        $stmt->execute(['id_orientacion' => $id_orientacion]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
