<?php
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

class DifuntoModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAllDifuntos(): array {
        $stmt = $this->db->prepare("SELECT * FROM difunto");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDifunto(int $id_difunto): array|false {
        $stmt = $this->db->prepare("SELECT * FROM difunto WHERE id_difunto = :id_difunto");
        $stmt->execute(['id_difunto' => $id_difunto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertDifunto(array $data): int {
        $stmt = $this->db->prepare("
            INSERT INTO difunto (
                id_deudo, nombre, apellido, dni, edad, fecha_fallecimiento,
                id_sexo, id_nacionalidad, id_estado_civil, domicilio, localidad, codigo_postal
            ) VALUES (
                :id_deudo, :nombre, :apellido, :dni, :edad, :fecha_fallecimiento,
                :id_sexo, :id_nacionalidad, :id_estado_civil, :domicilio, :localidad, :codigo_postal
            )
        ");

        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function updateDifunto(int $id_difunto, array $data): bool {
        $stmt = $this->db->prepare("
            UPDATE difunto SET 
                id_deudo = :id_deudo,
                nombre = :nombre,
                apellido = :apellido,
                dni = :dni,
                edad = :edad,
                fecha_fallecimiento = :fecha_fallecimiento,
                id_sexo = :id_sexo,
                id_nacionalidad = :id_nacionalidad,
                id_estado_civil = :id_estado_civil,
                domicilio = :domicilio,
                localidad = :localidad,
                codigo_postal = :codigo_postal
            WHERE id_difunto = :id_difunto
        ");

        $data['id_difunto'] = $id_difunto;
        $stmt->execute($data);
        return $stmt->rowCount() > 0;
    }

    public function deleteDifunto(int $id_difunto): bool {
        $stmt = $this->db->prepare("DELETE FROM difunto WHERE id_difunto = :id_difunto");
        $stmt->execute(['id_difunto' => $id_difunto]);
        return $stmt->rowCount() > 0;
    }
}

?>