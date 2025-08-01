<?php
// Carga la configuración del sistema y la clase para conectar a la base de datos
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';


/*
    * Modelo ParcelaModel
    * Maneja las operaciones CRUD para la tabla 'parcelas'
*/
class ParcelaModel {

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
         * Obtiene todas las parcelas
         * @return array Lista de parcelas
     */
    public function getAllParcelas(): array {
        $stmt = $this->db->prepare("SELECT * FROM parcela");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
         * Obtiene una parcela por su ID
         * @param int $id_parcela ID de la parcela
         * @return array Detalles de la parcela
     */
    public function getParcela(int $id_parcela): array|false {
        $stmt = $this->db->prepare("SELECT * FROM parcela WHERE id_parcela = :id_parcela");
        $stmt->execute(['id_parcela' => $id_parcela]);
        return $stmt->fetch();
    }

    /**
        * Inserta una nueva parcela
        * @param int $id_tipo ID del tipo de parcela
        * @param int $id_deudo ID del deudor
        * @param string $numero_ubicacion Número de ubicación
        * @param string $hilera Hilera de la parcela
        * @param string $seccion Sección de la parcela
        * @param string $fraccion Fracción de la parcela
        * @param int $nivel Nivel de la parcela
        * @param int $id_orientacion ID de la orientación
        * @return bool Resultado de la operación
    */
    public function insertParcela(
        int $id_tipo,
        int $id_deudo,
        string $numero_ubicacion,
        string $hilera,
        string $seccion,
        string $fraccion,
        int $nivel,
        int $id_orientacion
    ): int|false {
        $stmt = $this->db->prepare("
            INSERT INTO parcela (id_tipo, id_deudo, numero_ubicacion, hilera, seccion, fraccion, nivel, id_orientacion)
            VALUES (:id_tipo, :id_deudo, :numero_ubicacion, :hilera, :seccion, :fraccion, :nivel, :id_orientacion)
        ");
        if ($stmt->execute([
            'id_tipo' => $id_tipo,
            'id_deudo' => $id_deudo,
            'numero_ubicacion' => $numero_ubicacion,
            'hilera' => $hilera,
            'seccion' => $seccion,
            'fraccion' => $fraccion,
            'nivel' => $nivel,
            'id_orientacion' => $id_orientacion
        ])) {
            return intval($this->db->lastInsertId());
        }
        return false;
    }


    /**
        * Actualiza una parcela existente
        * @param int $id_parcela ID de la parcela a actualizar
    */
    public function updateParcela(
        int $id_parcela,
        int $id_tipo,
        int $id_deudo,
        string $numero_ubicacion,
        string $hilera,
        string $seccion,
        string $fraccion,
        int $nivel,
        int $id_orientacion
    ): bool {
        $stmt = $this->db->prepare("
            UPDATE parcela SET 
                id_tipo = :id_tipo,
                id_deudo = :id_deudo,
                numero_ubicacion = :numero_ubicacion,
                hilera = :hilera,
                seccion = :seccion,
                fraccion = :fraccion,
                nivel = :nivel,
                id_orientacion = :id_orientacion
            WHERE id_parcela = :id_parcela
        ");
        return $stmt->execute([
            'id_parcela' => $id_parcela,
            'id_tipo' => $id_tipo,
            'id_deudo' => $id_deudo,
            'numero_ubicacion' => $numero_ubicacion,
            'hilera' => $hilera,
            'seccion' => $seccion,
            'fraccion' => $fraccion,
            'nivel' => $nivel,
            'id_orientacion' => $id_orientacion
        ]);
    }

    /**
         * Elimina una parcela por su ID
         * @param int $id_parcela ID de la parcela a eliminar
         * @return bool Resultado de la operación
     */
    public function deleteParcela(int $id_parcela): bool {
        $stmt = $this->db->prepare("DELETE FROM parcela WHERE id_parcela = :id_parcela");
        $stmt->execute(['id_parcela' => $id_parcela]);
        return $stmt->rowCount() > 0;
    }
}
?>