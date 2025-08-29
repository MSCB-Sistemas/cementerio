<?php
require_once __DIR__ . '/../config/config.php';
require_once 'Database.php';

class PermisoModel {
    private $db;

    public function __construct() {
        $this->db = Database::conectar();
    }

    // 🔑 Devuelve un array con los nombres de los permisos de un rol
    public function getPermisosPorRol($id_tipo) 
    {
        $sql = "SELECT p.nombre_permiso
                  FROM permisos p
                  INNER JOIN rol_permiso rp ON p.id_permiso = rp.id_permiso
                WHERE rp.id_tipo_usuario = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_tipo]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN); 
        // Ejemplo: ['crear_usuario', 'eliminar_usuario', 'ver_estadisticas']
    }
}