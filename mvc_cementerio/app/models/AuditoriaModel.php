<?php
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

    public function getAllAuditorias(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM auditoria");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una auditoria por su ID
     * @param int $id_auditoria ID de la auditoria a buscar
     * @return array|false Datos de la auditoria o false si no se encuentra
     */
    public getAuditoria($id_auditoria): array{
        $stmt = $this->db->prepare("SELECT * FROM auditoria WHERE id_auditoria = :id_auditoria");
        $stmt->execute(['id_auditoria' => $id_auditoria]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Inserta una nueva auditoria
     * @param $id_sesion ID de la sesión de usuario
     * @param $id_usuario ID del usuario que registra la auditoria
     * @param $creado_en Fecha y hora de creación de la auditoria
     * @param $querys Consulta SQL ejecutada
     * @return int ID de la nueva auditoria insertada o false si falla
     */
    public function insertAuditoria($$id_sesion, $id_usuario, $creado_en, $querys): int{
        $stmt = $this->db->prepare("INSERT INTO auditoria (id_sesion, id_usuario, creado_en, querys) 
                                    VALUES (:id_sesion, :id_usuario, :creado_en, :querys)");
        $stmt->execute([
            'id_sesion' => $id_sesion,
            'id_usuario' => $id_usuario,
            'creado_en' => $creado_en,
            'querys' => $querys
        ]);
        return intval($this->db->lastInsertId());
    }
   
}


?>