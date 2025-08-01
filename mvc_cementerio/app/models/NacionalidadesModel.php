<?php
// Carga la configuración del sistema y la clase para conectar a la base de datos
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

/**
     * Modelo NacionalidadesModel
     * 
     * Esta clase gestiona todas las operaciones relacionadas con la tabla `nacionalidades`
     * en la base de datos. Permite obtener, insertar, actualizar y eliminar registros.
 */
class NacionalidadesModel {
    private PDO $db;

    /**
         * Constructor de la clase.
         * Establece la conexión a la base de datos utilizando la clase Database.
     */
    public function __construct() {
        $this->db = Database::connect();
    }

    /**
         * Obtiene todas las nacionalidades registradas.
         * 
         * @return array Lista de nacionalidades como arrays asociativos.
     */
    public function getAllNacionalidades(): array {
        $stmt = $this->db->prepare("SELECT * FROM nacionalidades");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
         * Obtiene una nacionalidad específica por su ID.
         * 
         * @param int $id_nacionalidad ID de la nacionalidad a obtener.
         * @return array|false Array asociativo con los datos o false si no se encuentra.
     */
    public function getNacionalidad(int $id_nacionalidad): array|false {
        $stmt = $this->db->prepare("SELECT * FROM nacionalidades WHERE id_nacionalidad = :id_nacionalidad");
        $stmt->execute(['id_nacionalidad' => $id_nacionalidad]);
        return $stmt->fetch();
    }

    /**
         * Inserta una nueva nacionalidad en la base de datos.
         * 
         * @param string $nacionalidad Nombre de la nacionalidad.
         * @return int|false ID de la nueva nacionalidad o false si falla la operación.
     */
    public function insertNacionalidad(string $nacionalidad): int|false {
        $stmt = $this->db->prepare("INSERT INTO nacionalidades (nacionalidad) VALUES (:nacionalidad)");
        if ($stmt->execute(['nacionalidad' => $nacionalidad])) {
            return intval($this->db->lastInsertId());
        }
        return false;
    }

    /**
         * Actualiza una nacionalidad existente.
         * 
         * @param int $id_nacionalidad ID de la nacionalidad a actualizar.
         * @param string $nacionalidad Nuevo valor de la nacionalidad.
         * @return bool True si se actualizó al menos una fila, false en caso contrario.
     */
    public function updateNacionalidad(int $id_nacionalidad, string $nacionalidad): bool {
        $stmt = $this->db->prepare("UPDATE nacionalidades SET nacionalidad = :nacionalidad WHERE id_nacionalidad = :id_nacionalidad");
        $stmt->execute([
            'id_nacionalidad' => $id_nacionalidad,
            'nacionalidad' => $nacionalidad
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
         * Elimina una nacionalidad de la base de datos.
         * 
         * @param int $id_nacionalidad ID de la nacionalidad a eliminar.
         * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    public function deleteNacionalidad(int $id_nacionalidad): bool {
        $stmt = $this->db->prepare("DELETE FROM nacionalidades WHERE id_nacionalidad = :id_nacionalidad");
        $stmt->execute(['id_nacionalidad' => $id_nacionalidad]);
        return $stmt->rowCount() > 0;
    }
}
?>
