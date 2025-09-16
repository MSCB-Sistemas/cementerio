<?php
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/models/Database.php';
require_once __DIR__ . '/../app/models/ParcelaModel.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Falta parámetro ID']);
    exit;
}

$id = intval($_GET['id']);

try {
    $parcelaModel = new ParcelaModel();
    $parcela = $parcelaModel->getParcela($id);

    if ($parcela) {
        echo json_encode($parcela);
    } else {
        echo json_encode(['error' => 'No encontrada']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
