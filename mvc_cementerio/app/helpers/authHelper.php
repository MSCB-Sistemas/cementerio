<?php
function isLoggedIn()
{
    session_start();
    return isset($_SESSION['usuario_id']);
}

function requireLogin()
{
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ' . URL . 'login');
        exit;
    }
}

function isLoggedInAdmin()
{
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 1;
}
?>