<?php 
require_once 'Database.php';

class AuditoriaHelper {
    public static function log(?int $id_usuario, string $query_sql, array $params = [], string $controller, string $accion): bool
    {
        try {
            /* @var PDO $db: Conexión a la base de datos */
            private PDO $db;

            /* Constructor: Inicializa la conexión a la base de datos */
            public function __construct() {
                $this->db = Database::connect();
            }

            // si no viene usuario explícito, lo sacamos de la sesión
            if ($id_usuario === null && isset($_SESSION['id_usuario'])) {
                $id_usuario = $_SESSION['id_usuario'];
            }

            $sql = "INSERT INTO auditoria (id_usuario, creado_en, query_sql, parametros, controller, accion) 
                    VALUES (:id_usuario, :creado_en, :query_sql, :parametros, :controller, :accion)";

            $paramsInsert = [
                'id_usuario' => $id_usuario,
                'creado_en'  => date('Y-m-d H:i:s'),
                'query_sql'  => $query_sql,
                
                if (!empty($params)){
                    json_encode($params, JSON_UNESCAPED_UNICODE);
                }else{
                    json_encode(null);
                }

                'controller' => $controller,
                'accion'     => $accion
            ];

            $stmt = $db->prepare($sql);
            return $stmt->execute($paramsInsert);

        } catch (Exception $e) {
            error_log("Error en auditoría: " . $e->getMessage());
            return false;
        }
    }
}
?>