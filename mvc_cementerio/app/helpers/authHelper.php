<?php
function isLoggedIn() {
    session_start();
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . URL . '/auth/login');
        exit;
    }
}

function isLoggedInAdmin() {
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 1;
}
?>