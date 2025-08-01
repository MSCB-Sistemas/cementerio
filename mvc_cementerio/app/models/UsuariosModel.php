<?php
// Carga la configuración del sistema y la clase para conectar a la base de datos
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

/**
     * Modelo UsuariosModel
     * 
     * Maneja las operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
     * para la tabla 'usuarios' en la base de datos.
     * Provee métodos para gestionar usuarios, incluyendo autenticación
     * y actualización segura de contraseñas.
 */
class UsuariosModel {
    private PDO $db;

    /**
         * Constructor
         * Inicializa la conexión a la base de datos usando la clase Database.
     */
    public function __construct() {
        $this->db = Database::connect();
    }

    /**
         * Obtiene todos los usuarios registrados en la base de datos.
         * 
         * @return array Arreglo con todos los usuarios.
     */
    public function getAllUsuarios(): array {
        $stmt = $this->db->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
         * Obtiene un usuario específico por su ID.
         * 
         * @param int $id_usuario ID del usuario a consultar.
         * @return array|false Datos del usuario o false si no existe.
     */
    public function getUsuarioId(int $id_usuario): array|false {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id_usuario = :id_usuario");
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->fetch();
    }

    /**
         * Obtiene un usuario por su nombre y apellido.
         * Útil para búsquedas específicas o validaciones.
         * 
         * @param string $nombre Nombre del usuario.
         * @param string $apellido Apellido del usuario.
         * @return array|false Datos del usuario o false si no existe.
     */
    public function getUsuarioPorNombreApellido(string $nombre, string $apellido): array|false {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE nombre = :nombre AND apellido = :apellido");
        $stmt->execute(['nombre' => $nombre, 'apellido' => $apellido]);
        return $stmt->fetch();
    }

    /**
         * Obtiene un usuario por su correo electrónico.
         * Útil para autenticación o recuperación de cuenta.
         * 
         * @param string $correo Correo electrónico del usuario.
         * @return array|false Datos del usuario o false si no existe.
     */
    public function getUsuarioPorCorreo(string $correo): array|false {
        $sql = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['correo' => $correo]);
        return $stmt->fetch();
    }

    /**
         * Inserta un nuevo usuario en la base de datos.
         * Hashea la contraseña antes de almacenarla para mayor seguridad.
         * 
         * @param string $correo Correo electrónico del nuevo usuario.
         * @param string $contrasenia Contraseña en texto plano.
         * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function insertarUsuario(string $correo, string $contrasenia): bool {
        $hash = password_hash($contrasenia, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (correo, contrasenia) VALUES (:correo, :contrasenia)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'correo' => $correo,
            'contrasenia' => $hash
        ]);
    }

    /**
         * Actualiza los datos de un usuario existente.
         * Si se proporciona una nueva contraseña, la hashea antes de actualizarla.
         * 
         * @param int $id_usuario ID del usuario a actualizar.
         * @param string $correo Nuevo correo electrónico.
         * @param string $nombre Nuevo nombre.
         * @param string $apellido Nuevo apellido.
         * @param string $cargo Nuevo cargo o posición.
         * @param string $sector Nuevo sector o departamento.
         * @param string|null $contrasenia Nueva contraseña (opcional).
         * @param int $id_tipo_usuario Nuevo tipo de usuario.
         * @param bool $activo Estado activo/inactivo del usuario.
         * @return bool True si la actualización fue exitosa, false si no se modificó nada.
     */
    public function updateUsuario(
        int $id_usuario,
        string $correo,
        string $nombre,
        string $apellido,
        string $cargo,
        string $sector,
        ?string $contrasenia,
        int $id_tipo_usuario,
        bool $activo
    ): bool {
        $params = [
            'id_usuario' => $id_usuario,
            'correo' => $correo,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'cargo' => $cargo,
            'sector' => $sector,
            'id_tipo_usuario' => $id_tipo_usuario,
            'activo' => $activo ? 1 : 0,
        ];

        $sql = "UPDATE usuarios SET
            correo = :correo,
            nombre = :nombre,
            apellido = :apellido,
            cargo = :cargo,
            sector = :sector,
            id_tipo_usuario = :id_tipo_usuario,
            activo = :activo";

        if ($contrasenia !== null) {
            $sql .= ", contrasenia = :contrasenia";
            $params['contrasenia'] = password_hash($contrasenia, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id_usuario = :id_usuario";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount() > 0;
    }

    /**
         * Elimina un usuario de la base de datos por su ID.
         * 
         * @param int $id_usuario ID del usuario a eliminar.
         * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteUsuario(int $id_usuario): bool {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id_usuario = :id_usuario");
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->rowCount() > 0;
    }
}
?>
