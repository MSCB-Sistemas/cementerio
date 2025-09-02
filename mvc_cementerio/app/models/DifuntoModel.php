<?php
require_once __DIR__ . '/../config/config.php';
require_once 'Database.php';

class DifuntoModel {
    private PDO $db;

    /**
     * Constructor
     * Establece la conexión a la base de datos al crear una instancia del modelo.
     */
    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Obtiene todos los registros de difuntos.
     * @return array Lista de difuntos como arrays asociativos.
     */
    public function getAllDifuntos(): array {
        $stmt = $this->db->prepare("SELECT 
                                                d.*,
                                                de.nombre AS nombre_deudo,
                                                s.descripcion AS sexo,
                                                ec.descripcion AS estado_civil,
                                                n.nacionalidad AS nacionalidad
                                        FROM difunto d
                                        LEFT JOIN deudo de ON d.id_deudo = de.id_deudo
                                        LEFT JOIN sexo s ON d.id_sexo = s.id_sexo
                                        LEFT JOIN estado_civil ec ON d.id_estado_civil = ec.id_estado_civil
                                        LEFT JOIN nacionalidades n ON d.id_nacionalidad = n.id_nacionalidad
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un difunto específico por su ID.
     * @param int $id_difunto ID del difunto.
     * @return array|false Datos del difunto como array asociativo, o false si no se encuentra.
     */
    public function getDifunto(int $id_difunto): array {
        $stmt = $this->db->prepare("SELECT * FROM difunto WHERE id_difunto = :id_difunto");
        $stmt->execute(['id_difunto' => $id_difunto]);
        return $stmt->fetch();
    }

    /**
     * Summary of insertDifunto
     * @param mixed $id_deudo
     * @param mixed $nombre
     * @param mixed $apellido
     * @param mixed $dni
     * @param mixed $edad
     * @param mixed $fecha_defuncion
     * @param mixed $id_sexo
     * @param mixed $id_nacionalidad
     * @param mixed $id_estado_civil
     * @param mixed $domicilio
     * @param mixed $localidad
     * @param mixed $codigo_postal
     * @return bool|string
     */
    public function insertDifunto($id_deudo, $nombre, $apellido, $dni, $edad, $fecha_defuncion, $id_sexo, $id_nacionalidad, $id_estado_civil, $domicilio, $localidad, $codigo_postal): int {
        $stmt = $this->db->prepare("
            INSERT INTO difunto (
                id_deudo, nombre, apellido, dni, edad, fecha_defuncion,
                id_sexo, id_nacionalidad, id_estado_civil, domicilio, localidad, codigo_postal
            ) VALUES (
                :id_deudo, :nombre, :apellido, :dni, :edad, :fecha_defuncion,
                :id_sexo, :id_nacionalidad, :id_estado_civil, :domicilio, :localidad, :codigo_postal
            )
        ");
        $stmt->execute([
            'id_deudo' => $id_deudo,
            'nombre'=> $nombre,
            'apellido' => $apellido,
            'dni' => $dni,
            'edad' => $edad,
            'fecha_defuncion'=> $fecha_defuncion,
            'id_sexo'=> $id_sexo,
            'id_nacionalidad'=> $id_nacionalidad,
            'id_estado_civil'=> $id_estado_civil,
            'domicilio'=> $domicilio,
            'localidad'=> $localidad,
            'codigo_postal'=> $codigo_postal
        ]); 
        
        return $this->db->lastInsertId();
    }

    /**
         * Actualiza los datos de un difunto existente.
         * @param int $id_difunto ID del difunto a actualizar.
         * @param array $data Datos nuevos para el difunto.
         * @return bool True si se actualizó al menos un campo, False si no hubo cambios.
     */
    public function updateDifunto(int $id_difunto, $id_deudo, $nombre, $apellido, $dni, $edad, $fecha_defuncion, $id_sexo, $id_nacionalidad, $id_estado_civil, $domicilio, $localidad, $codigo_postal): bool {
        $stmt = $this->db->prepare("
            UPDATE difunto SET 
                id_deudo = :id_deudo,
                nombre = :nombre,
                apellido = :apellido,
                dni = :dni,
                edad = :edad,
                fecha_defuncion = :fecha_defuncion,
                id_sexo = :id_sexo,
                id_nacionalidad = :id_nacionalidad,
                id_estado_civil = :id_estado_civil,
                domicilio = :domicilio,
                localidad = :localidad,
                codigo_postal = :codigo_postal
            WHERE id_difunto = :id_difunto
        ");
        $stmt->execute([
            "id_difunto"=> $id_difunto,
            "id_deudo" => $id_deudo,
            "nombre"=> $nombre,
            "apellido"=> $apellido,
            "dni"=> $dni,
            "edad"=> $edad,
            "fecha_defuncion"=> $fecha_defuncion,
            "id_sexo"=> $id_sexo,
            "id_nacionalidad"=> $id_nacionalidad,
            "id_estado_civil"=> $id_estado_civil,
            "domicilio"=> $domicilio,
            "localidad"=> $localidad,
            "codigo_postal"=> $codigo_postal
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
         * Elimina un difunto de la base de datos.
         * @param int $id_difunto ID del difunto a eliminar.
         * @return bool True si se eliminó, False si no se encontró o no se eliminó.
     */
    public function deleteDifunto(int $id_difunto): bool {
        $stmt = $this->db->prepare("DELETE FROM difunto WHERE id_difunto = :id_difunto");
        $stmt->execute(['id_difunto' => $id_difunto]);
        return $stmt->rowCount() > 0;
    }
}
?>
