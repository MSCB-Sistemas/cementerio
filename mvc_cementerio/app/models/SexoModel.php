<?php
// Carga la configuración del sistema y la clase para conectar a la base de datos
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

/*
    * Modelo SexoModel
    * Maneja las operaciones CRUD para la tabla 'sexo'
*/
class SexoModel {
    /**
        * @var PDO $db
        * Conexión a la base de datos
    */
    private PDO $db;

    /*
        * Constructor
        * Inicializa la conexión a la base de datos
    */
    public function __construct() {
        $this->db = Database::connect();
    }

    /**
         * Obtiene todos los sexos
         * @return array Lista de sexos
     */
    public function getAllSexos(): array {
        $stmt = $this->db->prepare("SELECT * FROM sexo");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
         * Obtiene un sexo por su ID
         * @param int $id_sexo ID del sexo
         * @return array Detalles del sexo
     */
    public function getSexo(int $id_sexo): array|false {
        $stmt = $this->db->prepare("SELECT * FROM sexo WHERE id_sexo = :id_sexo");
        $stmt->execute(['id_sexo' => $id_sexo]);
        return $stmt->fetch();
    }

    /** 
         * Inserta un nuevo sexo
         * @param int $id_sexo ID del sexo
         * @param string $descripcion Descripción del sexo
         * @return bool Resultado de la operación
    */
    public function insertSexo(string $descripcion): int|false {
        $stmt = $this->db->prepare("INSERT INTO sexo (descripcion) VALUES (:descripcion)");
        if ($stmt->execute(['descripcion' => $descripcion])) {
            return intval($this->db->lastInsertId());
        }
        return false;
    }

    /**
         * Actualiza un sexo
         * @param int $id_sexo ID del sexo
         * @param string $descripcion Descripción del sexo
         * @return bool Resultado de la operación
     */
    public function updateSexo(int $id_sexo, string $descripcion): bool {
        $stmt = $this->db->prepare("UPDATE sexo SET descripcion = :descripcion WHERE id_sexo = :id_sexo");
        $stmt->execute([
            'id_sexo' => $id_sexo,
            'descripcion' => $descripcion
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
         * Elimina un sexo por su ID
         * @param int $id_sexo ID del sexo a eliminar
         * @return bool Resultado de la operación
     */
    public function deleteSexo(int $id_sexo): bool {
        $stmt = $this->db->prepare("DELETE FROM sexo WHERE id_sexo = :id_sexo");
        $stmt->execute(['id_sexo' => $id_sexo]);
        return $stmt->rowCount() > 0;
    }
}
?>