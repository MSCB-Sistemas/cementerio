<?php
// Carga la configuración del sistema y la clase para conectar a la base de datos
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

/**
     * Modelo UbicacionDifuntoModel
     * 
     * Encargada de gestionar las operaciones relacionadas con la ubicación de los difuntos
     * en el cementerio. Realiza tareas de inserción, actualización, eliminación y consulta
     * sobre la tabla `ubicacion_difunto`.
 */
class UbicacionDifuntoModel {
    private PDO $db;

    /**
         * Constructor.
         * Establece la conexión con la base de datos utilizando la clase Database.
     */
    public function __construct() {
        $this->db = Database::connect();
    }

    /**
         * Obtiene todas las ubicaciones registradas en la base de datos.
         * 
         * @return array Lista de ubicaciones como arrays asociativos.
     */
    public function getAllUbicaciones(): array {
        $stmt = $this->db->prepare("SELECT * FROM ubicacion_difunto");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
         * Obtiene los datos de una ubicación específica por su ID.
         * 
         * @param int $id_ubicacion_difunto ID de la ubicación a consultar.
         * @return array|false Array asociativo con los datos de la ubicación o false si no se encuentra.
     */
    public function getUbicacionDifunto(int $id_ubicacion_difunto): array|false {
        $stmt = $this->db->prepare("SELECT * FROM ubicacion_difunto WHERE id_ubicacion_difunto = :id_ubicacion_difunto");
        $stmt->execute(['id_ubicacion_difunto' => $id_ubicacion_difunto]);
        return $stmt->fetch();
    }

    /**
         * Inserta una nueva ubicación para un difunto en la base de datos.
         * 
         * @param int $id_parcela ID de la parcela donde se ubica el difunto.
         * @param int $id_difunto ID del difunto que se ubica.
         * @param string|null $fecha_ingreso Fecha de ingreso del difunto (opcional).
         * @param string|null $fecha_retiro Fecha de retiro del difunto (opcional).
         * @return int|false ID de la nueva ubicación insertada o false en caso de error.
     */
    public function insertUbicacion(int $id_parcela, int $id_difunto, ?string $fecha_ingreso = null, ?string $fecha_retiro = null): int|false {
        $stmt = $this->db->prepare("
            INSERT INTO ubicacion_difunto (id_parcela, id_difunto, fecha_ingreso, fecha_retiro)
            VALUES (:id_parcela, :id_difunto, :fecha_ingreso, :fecha_retiro)
        ");
        if ($stmt->execute([
            'id_parcela' => $id_parcela,
            'id_difunto' => $id_difunto,
            'fecha_ingreso' => $fecha_ingreso,
            'fecha_retiro' => $fecha_retiro
        ])) {
            return intval($this->db->lastInsertId());
        }
        return false;
    }

    /**
         * Actualiza los datos de una ubicación existente.
         * 
         * @param int $id_ubicacion_difunto ID de la ubicación a actualizar.
         * @param int $id_parcela Nueva ID de parcela.
         * @param int $id_difunto Nueva ID de difunto.
         * @param string|null $fecha_ingreso Nueva fecha de ingreso (opcional).
         * @param string|null $fecha_retiro Nueva fecha de retiro (opcional).
         * @return bool True si se actualizó correctamente, false si no se modificó nada.
     */
    public function updateUbicacion(int $id_ubicacion_difunto, int $id_parcela, int $id_difunto, ?string $fecha_ingreso = null, ?string $fecha_retiro = null): bool {
        $stmt = $this->db->prepare("
            UPDATE ubicacion_difunto SET
                id_parcela = :id_parcela,
                id_difunto = :id_difunto,
                fecha_ingreso = :fecha_ingreso,
                fecha_retiro = :fecha_retiro
            WHERE id_ubicacion_difunto = :id_ubicacion_difunto
        ");
        $stmt->execute([
            'id_ubicacion_difunto' => $id_ubicacion_difunto,
            'id_parcela' => $id_parcela,
            'id_difunto' => $id_difunto,
            'fecha_ingreso' => $fecha_ingreso,
            'fecha_retiro' => $fecha_retiro
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
         * Elimina una ubicación específica de la base de datos.
         * 
         * @param int $id_ubicacion_difunto ID de la ubicación a eliminar.
         * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    public function deleteUbicacion(int $id_ubicacion_difunto): bool {
        $stmt = $this->db->prepare("DELETE FROM ubicacion_difunto WHERE id_ubicacion_difunto = :id_ubicacion_difunto");
        $stmt->execute(['id_ubicacion_difunto' => $id_ubicacion_difunto]);
        return $stmt->rowCount() > 0;
    }
}
?>
