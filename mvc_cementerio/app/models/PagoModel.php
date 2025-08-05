<?php
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
    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Obtiene todos los pagos registrados en la base de datos.
     * 
     * @return array Lista de pagos como arrays asociativos.
     */
    public function getAllPagos(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM pago");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un pago específico por su ID.
     * 
     * @param $id_pago ID del pago a consultar.
     * @return array Array asociativo con los datos del pago o false si no se encuentra.
     */
    public function getPago($id_pago): array
    {
        $stmt = $this->db->prepare("SELECT * FROM pago WHERE id_pago = :id_pago");
        $stmt->execute(['id_pago' => $id_pago]);
        return $stmt->fetch();
    }

    /**
     * Inserta un nuevo pago en la base de datos.
     * 
     * @param int $id_deudo ID del deudo asociado al pago.
     * @param int $id_parcela ID de la parcela asociada al pago.
     * @param string $fecha_pago Fecha del pago.
     * @param float $importe Importe del pago.
     * @param float $recargo Recargo aplicado al pago.
     * @param float $total Total del pago (importe + recargo).
     * @param int $id_usuario ID del usuario que realiza el pago.
     * @return int ID del nuevo pago insertado.
     */
    public function insertPago($id_deudo, $id_parcela, $fecha_pago, $importe, $recargo, $total, $id_usuario): int
    {
        $stmt = $this->db->prepare("INSERT INTO pago (id_deudo, id_parcela, fecha_pago, importe, recargo, total, id_usuario) 
                                    VALUES (:id_deudo, :id_parcela, :fecha_pago, :importe, :recargo, :total, :id_usuario)");
        $stmt->execute([
            "id_deudo" => $id_deudo,
            "id_parcela" => $id_parcela,
            "fecha_pago" => $fecha_pago,
            "importe" => $importe,
            "recargo" => $recargo,
            "total" => $total,
            "id_usuario" => $id_usuario
        ]);
        return $this->db->lastInsertId();
    }

    /** 
     * Actualiza un pago existente en la base de datos.
     * 
     * @param int $id_pago ID del pago a actualizar.
     * @param int $id_deudo ID del deudo asociado al pago.
     * @param int $id_parcela ID de la parcela asociada al pago.
     * @param string $fecha_pago Fecha del pago.
     * @param float $importe Importe del pago.
     * @param float $recargo Recargo aplicado al pago.
     * @param float $total Total del pago (importe + recargo).
     * @param int $id_usuario ID del usuario que realiza el pago.
     * @return bool True si se actualizó correctamente, false en caso contrario.
     */
    public function updatePago($id_pago, $id_deudo, $id_parcela, $fecha_pago, $importe, $recargo, $total, $id_usuario): bool
    {
        $stmt = $this->db->prepare("UPDATE pago SET id_deudo = :id_deudo, id_parcela = :id_parcela, fecha_pago = :fecha_pago, importe = :importe, recargo = :recargo, total = :total, id_usuario = :id_usuario
                                    WHERE id_pago = :id_pago");
        $stmt->execute([
            "id_pago" => $id_pago,
            "id_deudo" => $id_deudo,
            "id_parcela" => $id_parcela,
            "fecha_pago" => $fecha_pago,
            "importe" => $importe,
            "recargo" => $recargo,
            "total" => $total,
            "id_usuario" => $id_usuario
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Elimina un pago de la base de datos.
     * 
     * @param int $id_pago ID del pago a eliminar.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    public function deletePago($id_pago): bool
    {
        $stmt = $this->db->prepare("DELETE FROM pago WHERE id_pago = :id_pago");
        $stmt->execute(['id_pago' => $id_pago]);
        return $stmt->rowCount() > 0;
    }
}
?>
