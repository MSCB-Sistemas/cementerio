<?php
// Carga la configuración del sistema y la clase para conectar a la base de datos
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

/*
    * Modelo TipoParcelaModel
    * Maneja las operaciones CRUD para la tabla 'tipo_parcela' 
*/
class TipoParcelaModel {
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
         * Obtiene todos los tipos de parcelas
         * @return array Lista de tipos de parcelas
     */
    public function getAllTiposParcelas(): array {
        $stmt = $this->db->prepare("SELECT * FROM tipo_parcela");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
         * Obtiene un tipo de parcela por su ID
         * @param int $id_tipo ID del tipo de parcela
         * @return array Detalles del tipo de parcela
     */
    public function getTipoParcela(int $id_tipo): array|false {
        $stmt = $this->db->prepare("SELECT * FROM tipo_parcela WHERE id_tipo = :id_tipo");
        $stmt->execute(['id_tipo' => $id_tipo]);
        return $stmt->fetch();
    }

    /**
         * Inserta un nuevo tipo de parcela
         * @param int $id_tipo ID del tipo de parcela
         * @param string $nombre_parcela Nombre del tipo de parcela
         * @return bool Resultado de la operación
     */
    public function insertTipoParcela(string $nombre_parcela): int|false {
        $stmt = $this->db->prepare("INSERT INTO tipo_parcela (nombre_parcela) VALUES (:nombre_parcela)");
        if ($stmt->execute(['nombre_parcela' => $nombre_parcela])) {
            return intval($this->db->lastInsertId());
        }
        return false;
    }

    /**
         * Actualiza un tipo de parcela
         * @param int $id_tipo ID del tipo de parcela
         * @param string $nombre_parcela Nombre del tipo de parcela
         * @return bool Resultado de la operación
     */
    public function updateTipoParcela(int $id_tipo, string $nombre_parcela): bool {
        $stmt = $this->db->prepare("UPDATE tipo_parcela SET nombre_parcela = :nombre_parcela WHERE id_tipo = :id_tipo");
        $stmt->execute([
            'id_tipo' => $id_tipo,
            'nombre_parcela' => $nombre_parcela
        ]);
        return $stmt->rowCount() > 0;
    }

     /**
         * Elimina un tipo de parcela por su ID
         * @param int $id_tipo ID del tipo de parcela a eliminar
         * @return bool Resultado de la operación
     */
    public function deleteTipoParcela(int $id_tipo): bool {
        $stmt = $this->db->prepare("DELETE FROM tipo_parcela WHERE id_tipo = :id_tipo");
        $stmt->execute(['id_tipo' => $id_tipo]);
        return $stmt->rowCount() > 0;
    }
}
?>
