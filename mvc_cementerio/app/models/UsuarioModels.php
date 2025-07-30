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

    // Buscar usuario por correo
    public function verificar($correo) {
        $sql = "SELECT * FROM usuarios WHERE correo = :usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve usuario o false
    }

    // Registrar usuario
    public function registrar($correo, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (correo, password) VALUES (:correo, :contrasenia)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':password', $hash);
        return $stmt->execute();
    }
}