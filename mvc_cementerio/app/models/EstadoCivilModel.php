<?php

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

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un estado civil por su ID
     * @param int $id_estado_civil ID del estado civil
     * @return array Detalles del estado civil
     */
    public function getEstadoCivil($id_estado_civil) : array {
        $stmt = $this->db->prepare("SELECT * FROM estado_civil WHERE id_estado_civil = :id_estado_civil");
        $stmt->execute(['id_parcela' => $id_estado_civil]);
        return $stmt->fetch();
    }

    /**
        * Inserta un nuevo estado civil
        * @param string $nombre Nombre del estado civil
        * @return bool Resultado de la operación
    */

    public function insertEstadoCivil($id_estado_civil, $descripcion) {
        $stmt = $this->db->prepare("INSERT INTO estado_civil (id_estado_civil, descripcion) VALUES (:id_estado_civil, :descripcion)");
        return $stmt->execute([
            'id_estado_civil' => $id_estado_civil,
            'descripcion' => $descripcion,
        ]);
        return $this->db->lastInsertId();
    }

    /**
     * Actualiza un estado civil
     * @param int $id_estado_civil ID del estado civil
     * @param string $descripcion Descripción del estado civil
     * @return bool Resultado de la operación
     */
    public function updateParcela($id_estado_civil, $descripcion) : bool {
        $stmt = $this->db->prepare("UPDATE estado_civil SET id_estado_civil = :id_estado_civil, descripcion = :descripcion WHERE id_estado_civil = :id_estado_civil");
        return $stmt->execute([
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
    public function deleteParcela($id_estado_civil): bool {
        $stmt = $this->db->prepare("DELETE FROM estado_civil WHERE id_estado_civil = :id_estado_civil");
        $stmt->execute(['id_estado_civil' => $id_estado_civil]);
        return $stmt->rowCount() > 0;
    }
}
?>