<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/AuditoriaHelper.php';
require_once 'Database.php';

/**
 * Modelo DeudoModel
 * Maneja las operaciones CRUD para la tabla 'deudo'
 */
class DeudoModel {
    /**
     * @var PDO $db
     * Conexión a la base de datos
     */
    private PDO $db;

    /**
     * Constructor
     * Inicializa la conexión a la base de datos
     */
    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Obtiene todos los deudos registrados
     * @return array Lista de deudos
     */
    public function getAllDeudos(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM deudo");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un deudo por su ID
     * @param int $id_deudo ID del deudo
     * @return array|false Datos del deudo o false si no se encuentra
     */
    public function getDeudo($id_deudo): array
    {
        $stmt = $this->db->prepare("SELECT * FROM deudo WHERE id_deudo = :id_deudo");
        $stmt->execute(['id_deudo' => $id_deudo]);
        return $stmt->fetch();
    }

    /**
     * Inserta un nuevo deudo
     * @param $dni DNI del deudo
     * @param $nombre Nombre del deudo
     * @param $apellido Apellido del deudo
     * @param $telefono Teléfono del deudo
     * @param $email Correo electrónico del deudo
     * @param $domicilio Domicilio del deudo
     * @param $localidad Localidad del deudo
     * @param $codigo_postal Código postal del deudo
     * @return int ID del nuevo deudo insertado o false si falla
     */
    public function insertDeudo($dni, $nombre, $apellido, $telefono, $email, $domicilio, $localidad, $codigo_postal){
        $sql = "INSERT INTO deudo (dni, nombre, apellido, telefono, email, domicilio, localidad, codigo_postal)
                VALUES (:dni, :nombre, :apellido, :telefono, :email, :domicilio, :localidad, :codigo_postal)";
        $stmt = $this->db->prepare($sql);

        $parametros = [
            'dni' => $dni,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'email' => $email,
            'domicilio' => $domicilio,
            'localidad' => $localidad,
            'codigo_postal' => $codigo_postal
        ];
        $stmt->execute($parametros);

        // aquí registramos la auditoría
        AuditoriaHelper::log(
            $_SESSION['usuario_id'],    // usuario actual
            $sql,                       // Query SQL ejecutada
            $parametros,                // Parámetros
            "DeudoModel",               // Modelo
            "Insert"                    // Accion
        );
        return (int) $this->db->lastInsertId();
    }

    /**
     * Actualiza los detalles de un deudo en la base de datos.
     *
     * @param $id_deudo El identificador único del deudo.
     * @param mixed $dni El DNI (Documento Nacional de Identidad) del deudo.
     * @param mixed $nombre El nombre del deudo.
     * @param mixed $apellido El apellido del deudo.
     * @param mixed $telefono El número de teléfono del deudo.
     * @param mixed $email La dirección de correo electrónico del deudo.
     * @param mixed $domicilio El domicilio del deudo.
     * @param mixed $localidad La localidad o ciudad del deudo.
     * @param mixed $codigo_postal El código postal del domicilio del deudo.
     * @return bool Devuelve true si la actualización fue exitosa, false en caso contrario.
     */
    public function updateDeudo($id_deudo, $dni, $nombre, $apellido, $telefono, $email, $domicilio, $localidad, $codigo_postal): bool
    {
        $sql = "UPDATE deudo SET dni = :dni, nombre = :nombre, apellido = :apellido, telefono = :telefono, email = :email, domicilio = :domicilio, localidad = :localidad, codigo_postal = :codigo_postal
                WHERE id_deudo = :id_deudo";
        $stmt = $this->db->prepare($sql);
        $parametros = [
            'id_deudo' => $id_deudo,
            'dni' => $dni,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'email' => $email,
            'domicilio' => $domicilio,
            'localidad' => $localidad,
            'codigo_postal' => $codigo_postal
        ];
        $stmt->execute($parametros);

        // aquí registramos la auditoría
        AuditoriaHelper::log(
            $_SESSION['usuario_id'],    // usuario actual
            $sql,                       // Query SQL ejecutada
            $parametros,                // Parámetros
            "DeudoModel",               // Modelo
            "Update"                    // Accion
        );
        return $stmt->rowCount() > 0;
    }

    /**
     * Summary of deleteDeudo
     * @param int $id_deudo
     * @return bool
     */
    public function deleteDeudo(int $id_deudo): bool
    {
        $sql = "DELETE FROM deudo WHERE id_deudo = :id_deudo";
        $stmt = $this->db->prepare($sql);
        $parametros = ['id_deudo' => $id_deudo];
        $stmt->execute($parametros);

        // aquí registramos la auditoría
        AuditoriaHelper::log(
            $_SESSION['usuario_id'],    // usuario actual
            $sql,                       // Query SQL ejecutada
            $parametros,                // Parámetros
            "DeudoModel",             // Modelo
            "Delete"                    // Accion
        );
        return $stmt->rowCount() > 0;
    }
}
?>
