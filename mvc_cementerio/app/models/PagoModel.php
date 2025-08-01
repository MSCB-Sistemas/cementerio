<?php
// Carga la configuración del sistema y la clase para conectar a la base de datos
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

/**
     * Modelo PagoModel
     * 
     * Esta clase se encarga de gestionar las operaciones CRUD relacionadas con los pagos.
     * Accede a la tabla `pago` de la base de datos y permite registrar, consultar, actualizar y eliminar pagos.
 */
class PagoModel {
    private PDO $db;

    /**
         * Constructor.
         * Establece la conexión con la base de datos al instanciar la clase.
     */
    public function __construct() {
        $this->db = Database::connect();
    }

    /**
         * Obtiene todos los pagos registrados en la base de datos.
         * 
         * @return array Lista de pagos como arrays asociativos.
     */
    public function getAllPagos(): array {
        $stmt = $this->db->prepare("SELECT * FROM pago");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
         * Obtiene un pago específico por su ID.
         * 
         * @param int $id_pago ID del pago a consultar.
         * @return array|false Array asociativo con los datos del pago o false si no se encuentra.
     */
    public function getPago(int $id_pago): array|false {
        $stmt = $this->db->prepare("SELECT * FROM pago WHERE id_pago = :id_pago");
        $stmt->execute(['id_pago' => $id_pago]);
        return $stmt->fetch();
    }

    /**
         * Inserta un nuevo registro de pago en la base de datos.
         * 
         * @param array $data Datos del pago a insertar. Debe incluir:
         *                    - id_deudo
         *                    - id_parcela
         *                    - fecha_pago
         *                    - importe
         *                    - recargo
         *                    - total
         *                    - id_usuario
         * @return int|false ID del nuevo pago insertado o false si ocurre un error.
     */
    public function insertPago(array $data): int|false {
        $stmt = $this->db->prepare("
            INSERT INTO pago (
                id_deudo, id_parcela, fecha_pago, importe, recargo, total, id_usuario
            ) VALUES (
                :id_deudo, :id_parcela, :fecha_pago, :importe, :recargo, :total, :id_usuario
            )
        ");
        if ($stmt->execute($data)) {
            return intval($this->db->lastInsertId());
        }
        return false;
    }

    /**
         * Actualiza los datos de un pago existente.
         * 
         * @param int $id_pago ID del pago a actualizar.
         * @param array $data Nuevos datos del pago. Debe incluir:
         *                    - id_deudo
         *                    - id_parcela
         *                    - fecha_pago
         *                    - importe
         *                    - recargo
         *                    - total
         *                    - id_usuario
         * @return bool True si se actualizó correctamente, false si no se modificó nada.
     */
    public function updatePago(int $id_pago, array $data): bool {
        $stmt = $this->db->prepare("
            UPDATE pago SET 
                id_deudo = :id_deudo,
                id_parcela = :id_parcela,
                fecha_pago = :fecha_pago,
                importe = :importe,
                recargo = :recargo,
                total = :total,
                id_usuario = :id_usuario
            WHERE id_pago = :id_pago
        ");
        $data['id_pago'] = $id_pago;
        $stmt->execute($data);
        return $stmt->rowCount() > 0;
    }

    /**
         * Elimina un pago de la base de datos.
         * 
         * @param int $id_pago ID del pago a eliminar.
         * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    public function deletePago(int $id_pago): bool {
        $stmt = $this->db->prepare("DELETE FROM pago WHERE id_pago = :id_pago");
        $stmt->execute(['id_pago' => $id_pago]);
        return $stmt->rowCount() > 0;
    }
}
?>
