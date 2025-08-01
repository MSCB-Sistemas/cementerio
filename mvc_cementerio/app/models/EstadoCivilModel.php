<?php
// Carga la configuración del sistema y la clase para conectar a la base de datos
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

/*
    * Modelo EstadoCivilModel
    * Maneja las operaciones CRUD para la tabla 'estado_civil'
*/
class EstadoCivilModel {

    /**
        * @var PDO $db
        * Conexión a la base de datos
    */
    private PDO $db;

     /*
        * Constructor
        * Inicializa la conexión a la base de datos
    */
    public function __construct() {
        $this->db = Database::connect();
    }

    /**
         * Obtiene todos los estados civiles
         * @return array Lista de estados civiles
     */
    public function getAllEstadosCiviles(): array {
        $stmt = $this->db->prepare("SELECT * FROM estado_civil");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
         * Obtiene un estado civil por su ID
         * @param int $id_estado_civil ID del estado civil
         * @return array Detalles del estado civil
     */
    public function getEstadoCivil(int $id_estado_civil): array|false {
        $stmt = $this->db->prepare("SELECT * FROM estado_civil WHERE id_estado_civil = :id_estado_civil");
        $stmt->execute(['id_estado_civil' => $id_estado_civil]);
        return $stmt->fetch();
    }

    /**
        * Inserta un nuevo estado civil
        * @param string $nombre Nombre del estado civil
        * @return bool Resultado de la operación
    */
    public function insertEstadoCivil(string $descripcion): int|false {
        $stmt = $this->db->prepare("INSERT INTO estado_civil (descripcion) VALUES (:descripcion)");
        if ($stmt->execute(['descripcion' => $descripcion])) {
            return intval($this->db->lastInsertId());
        }
        return false;
    }

    /**
         * Actualiza un estado civil
         * @param int $id_estado_civil ID del estado civil
         * @param string $descripcion Descripción del estado civil
         * @return bool Resultado de la operación
     */
    public function updateEstadoCivil(int $id_estado_civil, string $descripcion): bool {
        $stmt = $this->db->prepare("UPDATE estado_civil SET descripcion = :descripcion WHERE id_estado_civil = :id_estado_civil");
        $stmt->execute([
            'id_estado_civil' => $id_estado_civil,
            'descripcion' => $descripcion
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
         * Elimina un estado civil
         * @param int $id_estado_civil ID del estado civil a eliminar
         * @return bool Resultado de la operación
     */
    public function deleteEstadoCivil(int $id_estado_civil): bool {
        $stmt = $this->db->prepare("DELETE FROM estado_civil WHERE id_estado_civil = :id_estado_civil");
        $stmt->execute(['id_estado_civil' => $id_estado_civil]);
        return $stmt->rowCount() > 0;
    }
}
?>