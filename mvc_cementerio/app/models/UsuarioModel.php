<?php
require_once __DIR__ . '/../config/config.php';
require_once 'Database.php';

class UsuarioModel {
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    //Obtener todos los usuarios
    public function getAllUsuarios(): array {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Buscar usuario por id
    public function getUsuarioId($id_usuario) : array {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->fetch();
    }
    
    
    public function buscarUsuarios(array $filtros): array {
        $condiciones = [];
        foreach ($filtros as $campo => $valor) {
            $condiciones[] = "$campo = :$campo";
        } 
        $sql = "SELECT * FROM usuarios";
        if (!empty($condiciones)) {
            $sql .= " WHERE " . implode(' AND ', $condiciones);
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($filtros);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Verificar login
    function verificarLogin($usuario, $contrasenia) {
    $query = "SELECT * FROM usuarios WHERE username = :username LIMIT 1";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':username', $usuario);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($contrasenia, $usuario['contrasenia'])) {
            return $usuario;
        }
    }
    return false;
}



    // Insertar usuario
    public function insertUsuario($email, $contrasenia) {
        $hash = password_hash($contrasenia, PASSWORD_DEFAULT);     // Encripta la contraseña
        $sql = "INSERT INTO usuarios (email, contrasenia) VALUES (:email, :contrasenia)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'email'=> $email, 
            'contrasenia'=> $hash
        ]);
    }

    //Actualizar usuario
    public function actualizarUsuario(int $id_usuario, array $datos): bool {
        // Si se pasa contraseña, la hasheamos
        if (isset($datos['contrasenia']) && !empty($datos['contrasenia'])) {
            $datos['contrasenia'] = password_hash($datos['contrasenia'], PASSWORD_DEFAULT);
        }

        // Construir los campos dinámicamente
        $campos = [];
        foreach ($datos as $campo => $valor) {
            $campos[] = "$campo = :$campo";
        }

        // Prepara la consulta con placeholders
        $sql = "UPDATE usuarios SET " . implode(', ', $campos) . " WHERE id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);

        // Agregar el id_usuario a los datos
        $datos['id_usuario'] = $id_usuario;

        // Ejecuta sustituyendo los placeholders por los valores del array
        return $stmt->execute($datos);
    }

    //Eliminar usuario
    public function deleteUsuario($id_usuario): bool {
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id_usuario' => $id_usuario]);
    }

}