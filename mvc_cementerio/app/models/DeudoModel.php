<?php
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

class DeudoModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAllDeudos(): array {
        $stmt = $this->db->prepare("SELECT * FROM deudo");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDeudo(int $id_deudo): array|false {
        $stmt = $this->db->prepare("SELECT * FROM deudo WHERE id_deudo = :id_deudo");
        $stmt->execute(['id_deudo' => $id_deudo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertDeudo($dni, $nombre, $apellido, $telefono, $email, $domicilio, $localidad, $codigo_postal) {
        $stmt = $this->db->prepare("
            INSERT INTO deudo (dni, nombre, apellido, telefono, email, domicilio, localidad, codigo_postal)
            VALUES (:dni, :nombre, :apellido, :telefono, :email, :domicilio, :localidad, :codigo_postal)
        ");
        $stmt->execute([
            'dni' => $dni,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'email' => $email,
            'domicilio' => $domicilio,
            'localidad' => $localidad,
            'codigo_postal' => $codigo_postal
        ]);
        return $this->db->lastInsertId();
    }

    public function updateDeudo(int $id_deudo, array $data): bool {
        $stmt = $this->db->prepare("
            UPDATE deudo SET 
                dni = :dni,
                nombre = :nombre,
                apellido = :apellido,
                telefono = :telefono,
                email = :email,
                domicilio = :domicilio,
                localidad = :localidad,
                codigo_postal = :codigo_postal
            WHERE id_deudo = :id_deudo
        ");
        $data['id_deudo'] = $id_deudo;
        $stmt->execute($data);
        return $stmt->rowCount() > 0;
    }

    public function deleteDeudo(int $id_deudo): bool {
        $stmt = $this->db->prepare("DELETE FROM deudo WHERE id_deudo = :id_deudo");
        $stmt->execute(['id_deudo' => $id_deudo]);
        return $stmt->rowCount() > 0;
    }
}

?>