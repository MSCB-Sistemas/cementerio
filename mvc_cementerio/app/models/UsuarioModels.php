<?php
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

class UsuarioModel {
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    //Obtener todos los usuarios
    public function getAllUsuarios(): array {
        $stmt = $this->db->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsuarioId($id_usuario) : array {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id_usuario = :id_usuario");
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->fetch();
    }

    public function getUsuarioPorNombreApellido($nombre, $apellido) : array {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE nombre = :nombre AND apellido = :apellido");
        $stmt->execute(['nombre' => $nombre, 'apellido' => $apellido]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar usuario por correo
    public function verificar($correo) :bool {
        $sql = "SELECT * FROM usuarios WHERE correo = :usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $correo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve usuario o false
    }

    // Insertar usuario
    public function insertarUsuario($correo, $contrasenia) {
        $hash = password_hash($contrasenia, PASSWORD_DEFAULT);     //// Encripta la contraseña
        $sql = "INSERT INTO usuarios (usuario, contrasenia) VALUES (:usuario, :contrasenia)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario', $correo);
        $stmt->bindParam(':contrasenia', $hash);
        return $stmt->execute();
    }

    //Actualizar usuario
    public function updateUsuario($id_usuario, $usuario, $nombre, $apellido, $cargo, $sector, $contrasenia, $id_tipo_usuario, $activo) {
        $sql = "UPDATE usuarios SET id_usuario=:id_usuario, usuario=:usuario, nombre=:nombre, apellido=:apellido, cargo=:cargo, sector=:sector, password=:contrasenia WHERE id_usuario=:id_usuario";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id_usuario' => $id_usuario,
            
        ]);
    }
}