<?php
require_once __DIR__ . '/../config/config.php';
require_once 'Database.php';

class UsuarioModel {
    private PDO $db;

    /* Constructor
     * Inicializa la conexión a la base de datos
     */
    public function __construct()
    {
        $this->db = Database::connect();
    }

    /** 
     * Obtener todos los usuarios
     * @return array Lista de usuarios
     */
    public function getAllUsuarios(): array
    {
        $stmt = $this->db->prepare("SELECT 
            u.id_usuario,
            u.usuario,
            u.nombre,
            u.apellido,
            u.cargo,
            u.sector,
            tu.descripcion,
            u.activo
        FROM 
            usuarios u
        JOIN 
            tipos_usuarios tu ON u.id_tipo_usuario = tu.id_tipo_usuario;
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** 
     * Obtener un usuario por su ID
     * @param int $id_usuario ID del usuario
     * @return array Detalles del usuario
     */
    public function getUsuarioId($id_usuario): array
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id_usuario = :id_usuario");
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->fetch();
    }


    // Verificar login
    function verificarLogin($usuario, $contrasenia) {
    $query = "SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($contrasenia, $usuario['contrasenia'])) {
            return $usuario;
        }
    }
    return false;
}

    /**
     * Summary of insertUsuario
     * @param mixed $usuario
     * @param mixed $nombre
     * @param mixed $apellido
     * @param mixed $cargo
     * @param mixed $sector
     * @param mixed $contrasenia
     * @param mixed $id_tipo_usuario
     * @return bool
     */
    public function insertUsuario($usuario, $nombre, $apellido, $cargo, $sector, $contrasenia, $id_tipo_usuario): bool
    {
        $stmt = $this->db->prepare("INSERT INTO usuarios (usuario, nombre, apellido, cargo, sector, contrasenia, id_tipo_usuario) 
                                    VALUES (:usuario, :nombre, :apellido, :cargo, :sector, :contrasenia, :id_tipo_usuario)");
        return $stmt->execute([
            "usuario" => $usuario,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "cargo" => $cargo,
            "sector" => $sector,
            "contrasenia" => password_hash($contrasenia, PASSWORD_DEFAULT),
            "id_tipo_usuario" => $id_tipo_usuario
        ]);
    }

    /** 
     * Update usuario
     * 
     * @param int $id_usuario ID del usuario a actualizar
     * @param string $usuario Nuevo nombre de usuario
     * @param string $nombre Nuevo nombre
     * @param string $apellido Nuevo apellido
     * @param string $cargo Nuevo cargo
     * @param string $sector Nuevo sector
     * @param string $contrasenia Nueva contraseña
     * @param int $id_tipo_usuario Nuevo tipo de usuario
     * @param bool $activo Estado activo del usuario
     * @return bool Resultado de la actualización
     */
    public function updateUsuario($id_usuario, $usuario, $nombre, $apellido, $cargo, $sector, $id_tipo_usuario): bool
    {
        $stmt = $this->db->prepare("UPDATE usuarios 
                                    SET usuario = :usuario, nombre = :nombre, apellido = :apellido, cargo = :cargo, sector = :sector, id_tipo_usuario = :id_tipo_usuario 
                                    WHERE id_usuario = :id_usuario");
        $stmt->execute([
            "id_usuario" => $id_usuario,
            "usuario" => $usuario,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "cargo" => $cargo,
            "sector" => $sector,
            "id_tipo_usuario" => $id_tipo_usuario,
        ]);
        return $stmt->rowCount() > 0;
    }

    /**     
     * Elimina un usuario por su ID
     * @param $id_usuario ID del usuario a eliminar
     * @return bool Resultado de la eliminación
     */
    public function deleteUsuario($id_usuario): bool
    {
        $stmt = $this->db->prepare("UPDATE usuarios SET activo = 0 WHERE id_usuario = :id_usuario");
        $stmt->execute(array('id_usuario' => $id_usuario));

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /** Actualizar contraseña */
    public function updatePassword($id_usuario, $password): bool {
        $stmt = $this->db->prepare("UPDATE usuarios SET contrasenia = :contrasenia WHERE id_usuario = :id_usuario");
        $stmt->execute(array('id_usuario' => $id_usuario, 'contrasenia' => $password));

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}