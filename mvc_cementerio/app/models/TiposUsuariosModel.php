<?php
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

/**
 * Modelo TipoUsuariosModel
 * 
 * Esta clase gestiona todas las operaciones relacionadas con los tipos de usuarios.
 * Permite acceder, crear, modificar y eliminar registros de la tabla `tipos_usuarios`.
 */
class TipoUsuariosModel {
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
     * Obtiene todos los tipos de usuarios existentes en la base de datos.
     * 
     * @return array Lista de tipos de usuarios como arrays asociativos.
     */
    public function getAllTiposUsuarios(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM tipos_usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un tipo de usuario específico por su ID.
     * 
     * @param $id_tipo_usuario ID del tipo de usuario a consultar.
     * @return array Array asociativo con los datos del tipo de usuario o false si no se encuentra.
     */
    public function getTipoUsuario($id_tipo_usuario): array
    {
        $stmt = $this->db->prepare("SELECT * FROM tipos_usuarios WHERE id_tipo_usuario = :id_tipo_usuario");
        $stmt->execute(['id_tipo_usuario' => $id_tipo_usuario]);
        return $stmt->fetch();
    }

    /**
     * Inserta un nuevo tipo de usuario en la base de datos.
     * 
     * @param string $descripcion Descripción del nuevo tipo de usuario.
     * @return int ID del nuevo tipo de usuario insertado o false si ocurre un error.
     */
    public function insertTipoUsuario($descripcion): int
    {
        $stmt = $this->db->prepare("INSERT INTO tipos_usuarios (descripcion) VALUES (:descripcion)");
        $stmt->execute(['descripcion' => $descripcion]);
        return $this->db->lastInsertId();
    }

    /**
     * Actualiza la descripción de un tipo de usuario existente.
     * 
     * @param int $id_tipo_usuario ID del tipo de usuario a actualizar.
     * @param string $descripcion Nueva descripción del tipo de usuario.
     * @return bool True si se actualizó correctamente, false si no se modificó nada.
     */
    public function updateTipoUsuario($id_tipo_usuario, $descripcion): bool
    {
        $stmt = $this->db->prepare("UPDATE tipos_usuarios SET descripcion = :descripcion 
                                    WHERE id_tipo_usuario = :id_tipo_usuario");
        $stmt->execute([
            'id_tipo_usuario' => $id_tipo_usuario,
            'descripcion' => $descripcion
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Elimina un tipo de usuario de la base de datos.
     * 
     * @param int $id_tipo_usuario ID del tipo de usuario a eliminar.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    public function deleteTipoUsuario(int $id_tipo_usuario): bool
    {
        $stmt = $this->db->prepare("DELETE FROM tipos_usuarios WHERE id_tipo_usuario = :id_tipo_usuario");
        $stmt->execute(['id_tipo_usuario' => $id_tipo_usuario]);
        return $stmt->rowCount() > 0;
    }
}
?>
