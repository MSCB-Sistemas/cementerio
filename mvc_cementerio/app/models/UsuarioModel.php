<?php
require_once __DIR__ . '/../config/config.php';
require_once 'Database.php';

class UsuarioModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /** Obtener todos los usuarios */
    public function getAllUsuarios(): array {
        $stmt = $this->db->prepare(
            "SELECT 
                u.id_usuario,
                u.usuario,
                u.nombre,
                u.apellido,
                u.cargo,
                u.sector,
                u.telefono,
                u.email,
                tu.descripcion,
                u.activo
            FROM usuarios u
            JOIN tipos_usuarios tu ON u.id_tipo_usuario = tu.id_tipo_usuario;"
        );
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($usuarios == false) {
            return array();
        } else {
            // Transformar activo a texto "Si" o "No"
            foreach ($usuarios as &$usuario) {
                $usuario['activo'] = $usuario['activo'] == 1 ? 'Si' : 'No';
            }
            return $usuarios;
        }
    }


    /** Obtener un usuario por ID */
    public function getUsuarioId($id_usuario): array {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id_usuario = :id_usuario");
        $stmt->execute(array('id_usuario' => $id_usuario));
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario == false) {
            return array();
        } else {
            return $usuario;
        }
    }

    /** Verificar login */
    public function verificarLogin($usuario, $contrasenia) {
        $query = "SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($contrasenia, $usuarioEncontrado['contrasenia'])) {
                return $usuarioEncontrado;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /** Insertar usuario */
    public function insertUsuario($usuario, $nombre, $apellido, $cargo, $sector, $telefono, $email, $contrasenia, $id_tipo_usuario): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO usuarios (usuario, nombre, apellido, cargo, sector, telefono, email, contrasenia, id_tipo_usuario, activo) 
             VALUES (:usuario, :nombre, :apellido, :cargo, :sector, :telefono, :email, :contrasenia, :id_tipo_usuario, 1)"
        );

        $contraseniaEncriptada = password_hash($contrasenia, PASSWORD_DEFAULT);

        $resultado = $stmt->execute(array(
            'usuario' => $usuario,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'cargo' => $cargo,
            'sector' => $sector,
            'telefono' => $telefono,
            'email' => $email,
            'contrasenia' => $contraseniaEncriptada,
            'id_tipo_usuario' => $id_tipo_usuario
        ));

        if ($resultado == true) {
            return true;
        } else {
            return false;
        }
    }

    /** Actualizar usuario */
    public function updateUsuario($id_usuario, $usuario, $nombre, $apellido, $cargo, $sector, $telefono, $email, $id_tipo_usuario): bool {
        $stmt = $this->db->prepare(
            "UPDATE usuarios 
             SET usuario = :usuario, nombre = :nombre, apellido = :apellido, cargo = :cargo, sector = :sector, id_tipo_usuario = :id_tipo_usuario 
             WHERE id_usuario = :id_usuario"
        );

        $stmt->execute(array(
            'id_usuario' => $id_usuario,
            'usuario' => $usuario,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'cargo' => $cargo,
            'sector' => $sector,
            'telefono' => $telefono,
            'email' => $email,
            'id_tipo_usuario' => $id_tipo_usuario
        ));

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /** Activar usuario */
    public function activateUsuario($id_usuario): bool {
        $stmt = $this->db->prepare("UPDATE usuarios SET activo = 1 WHERE id_usuario = :id_usuario");
        $stmt->execute(array('id_usuario' => $id_usuario));

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /** Eliminar usuario (desactivar) */
    public function deleteUsuario($id_usuario): bool {
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
?>