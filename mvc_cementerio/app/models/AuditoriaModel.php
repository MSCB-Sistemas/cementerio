<?php
require_once __DIR__ . '/../config/config.php';
require_once 'Database.php';

/**
 * Modelo DeudoModel
 * Inserta y lista registros de auditoría en BD.
 */
class AuditoriaModel {

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

    /** Lista todo el historial (más reciente primero) */
    public function getAllAuditorias(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM auditoria ORDER BY creado_en DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una auditoria por su ID
     * @param int $id_auditoria ID de la auditoria a buscar
     * @return array|false Devuelve array o false si no existe.
     */
    public function getAuditoria($id_auditoria): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM auditoria WHERE id_auditoria = :id_auditoria");
        $stmt->execute(['id_auditoria' => $id_auditoria]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row){
            return $row;
        }else{
            return false; // No se encontró la auditoria
        }
    }

    /**
     * Inserta una nueva auditoria
     * @param $id_auditoria ID de la sesión de usuario
     * @param $id_usuario ID del usuario que registra la auditoria
     * @param $creado_en Fecha y hora de creación de la auditoria. Si se pasa null, usa NOW() (Default currente_timestamp)
     * @param $query_sql Consulta SQL ejecutada
     * @param $controller Nombre del controlador
     * @param $action Nombre de la acción
     * @return int ID de la nueva auditoria insertada o false si falla
     */
    public function insertAuditoria($id_auditoria, $id_usuario, $query_sql, $controller, $accion): int|false
    {
        $sql = "INSERT INTO auditoria (id_auditoria, id_usuario, creado_en, query_sql, controller, accion) 
                                VALUES (:id_auditoria, :id_usuario, :creado_en, :query_sql, :controller, :accion)";
        $params = [
            'id_auditoria' => $id_auditoria,
            'id_usuario' => $id_usuario,
            'creado_en' => $creado_en->date('Y-m-d H:i:s'), // Formateamos a string
            'query_sql' => $query_sql
            'controller' => $controller,
            'accion' => $accion
        ];                       
    
        $stmt = $this->db->prepare($sql)
        $stmt->execute($params);

        return intval($this->db->lastInsertId()); // Devuelve el Id de la auditoria insertada
    }
}


?>