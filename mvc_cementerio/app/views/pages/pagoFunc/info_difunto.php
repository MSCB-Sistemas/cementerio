<?php
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/models/Database.php';
require_once __DIR__ . '/../app/models/DifuntoModel.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Falta parámetro ID']);
    exit;
}

$id = intval($_GET['id']);

try {
    $difuntoModel = new DifuntoModel();
    $difunto = $difuntoModel->getDifunto($id);

    if ($difunto) {
        echo json_encode($difunto);
    } else {
        echo json_encode(['error' => 'No encontrado']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
