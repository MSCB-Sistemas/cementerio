<?php
// Carga la configuración del sistema y la clase para conectar a la base de datos
require_once __DIR__ . '/../config/config.php';
require_once 'Database.php';

/**
     * Modelo DeudoModel
     * Maneja las operaciones CRUD para la tabla 'deudo'
 */
class DeudoModel {

    /**
         * @var PDO $db
         * Conexión a la base de datos
     */
    private PDO $db;

    /**
         * Constructor
         * Inicializa la conexión a la base de datos
     */
    public function __construct() {
        $this->db = Database::connect();
    }

    /**
         * Obtiene todos los deudos registrados
         * @return array Lista de deudos
     */
    public function getAllDeudos(): array {
        try {
            $stmt = $this->db->prepare("SELECT * FROM deudo");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Manejar error o loguear
            return [];
        }
    }

    /**
         * Obtiene un deudo por su ID
         * @param int $id_deudo ID del deudo
         * @return array|false Datos del deudo o false si no se encuentra
     */
    public function getDeudo(int $id_deudo): array|false {
        $stmt = $this->db->prepare("SELECT * FROM deudo WHERE id_deudo = :id_deudo");
        $stmt->execute(['id_deudo' => $id_deudo]);
        return $stmt->fetch();
    }

    /**
         * Inserta un nuevo deudo
         * @param string $dni DNI del deudo
         * @param string $nombre Nombre del deudo
         * @param string $apellido Apellido del deudo
         * @param string $telefono Teléfono del deudo
         * @param string $email Correo electrónico del deudo
         * @param string $domicilio Domicilio del deudo
         * @param string $localidad Localidad del deudo
         * @param string $codigo_postal Código postal del deudo
         * @return int|false ID del nuevo deudo insertado o false si falla
     */
    public function insertDeudo(
        string $dni,
        string $nombre,
        string $apellido,
        string $telefono,
        string $email,
        string $domicilio,
        string $localidad,
        string $codigo_postal
    ): int|false {
        $stmt = $this->db->prepare("
            INSERT INTO deudo (dni, nombre, apellido, telefono, email, domicilio, localidad, codigo_postal)
            VALUES (:dni, :nombre, :apellido, :telefono, :email, :domicilio, :localidad, :codigo_postal)
        ");
        if ($stmt->execute([
            'dni' => $dni,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'email' => $email,
            'domicilio' => $domicilio,
            'localidad' => $localidad,
            'codigo_postal' => $codigo_postal
        ])) {
            return intval($this->db->lastInsertId());
        }
        return false;
    }

    /**
         * Actualiza los datos de un deudo existente
         * @param int $id_deudo ID del deudo a actualizar
         * @param array $data Datos a actualizar (deben incluir todas las claves)
         * @return bool Resultado de la operación
     */
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

    /**
         * Elimina un deudo por su ID
         * @param int $id_deudo ID del deudo a eliminar
         * @return bool Resultado de la operación
     */
    public function deleteDeudo(int $id_deudo): bool {
        $stmt = $this->db->prepare("DELETE FROM deudo WHERE id_deudo = :id_deudo");
        $stmt->execute(['id_deudo' => $id_deudo]);
        return $stmt->rowCount() > 0;
    }
}
?>
