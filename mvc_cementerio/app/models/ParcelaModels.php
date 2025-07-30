<?php
require_once __DIR__ . '/config/config.php';
require_once 'Database.php';

class ParcelaModel {
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAllParcelas(): array {
        $stmt = $this->db->prepare("SELECT * FROM parcelas");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getParcela($id_parcela) : array {
        $stmt = $this->db->prepare("SELECT * FROM parcelas WHERE id_parcela = :id");
        $stmt->execute(['id_parcela' => $id_parcela]);
        return $stmt->fetch();
    }
}
?>