<?php
// Carga la configuración del sistema y la clase para conectar a la base de datos
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

/**
     * Modelo DifuntoModel
     * Encargado de gestionar las operaciones relacionadas con los difuntos en la base de datos.
     * Forma parte de la capa Modelo del patrón MVC.
 */
class DifuntoModel {
    // Instancia de la conexión PDO a la base de datos
    private PDO $db;

    /**
         * Constructor
         * Establece la conexión a la base de datos al crear una instancia del modelo.
     */
    public function __construct() {
        $this->db = Database::connect();
    }

    /**
         * Obtiene todos los registros de difuntos.
         * @return array Lista de difuntos como arrays asociativos.
     */
    public function getAllDifuntos(): array {
        $stmt = $this->db->prepare("SELECT * FROM difunto");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
         * Obtiene un difunto específico por su ID.
         * @param int $id_difunto ID del difunto.
         * @return array|false Datos del difunto como array asociativo, o false si no se encuentra.
     */
    public function getDifunto(int $id_difunto): array|false {
        $stmt = $this->db->prepare("SELECT * FROM difunto WHERE id_difunto = :id_difunto");
        $stmt->execute(['id_difunto' => $id_difunto]);
        return $stmt->fetch();
    }

    /**
         * Inserta un nuevo registro de difunto en la base de datos.
         * @param array $data Datos del difunto (usando claves con nombres de columnas).
         * @return int|false ID del nuevo difunto insertado o false en caso de error.
     */
    public function insertDifunto(array $data): int|false {
        $stmt = $this->db->prepare("
            INSERT INTO difunto (
                id_deudo, nombre, apellido, dni, edad, fecha_fallecimiento,
                id_sexo, id_nacionalidad, id_estado_civil, domicilio, localidad, codigo_postal
            ) VALUES (
                :id_deudo, :nombre, :apellido, :dni, :edad, :fecha_fallecimiento,
                :id_sexo, :id_nacionalidad, :id_estado_civil, :domicilio, :localidad, :codigo_postal
            )
        ");
        if ($stmt->execute($data)) {
            return intval($this->db->lastInsertId());
        }
        return false;
    }

    /**
         * Actualiza los datos de un difunto existente.
         * @param int $id_difunto ID del difunto a actualizar.
         * @param array $data Datos nuevos para el difunto.
         * @return bool True si se actualizó al menos un campo, False si no hubo cambios.
     */
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

    /**
         * Elimina un difunto de la base de datos.
         * @param int $id_difunto ID del difunto a eliminar.
         * @return bool True si se eliminó, False si no se encontró o no se eliminó.
     */
    public function deleteDifunto(int $id_difunto): bool {
        $stmt = $this->db->prepare("DELETE FROM difunto WHERE id_difunto = :id_difunto");
        $stmt->execute(['id_difunto' => $id_difunto]);
        return $stmt->rowCount() > 0;
    }
}
?>
