<?php
// Inclua esse arquivo no topo de cada página protegida com:
// require_once 'auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
?>