<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/conexion.php';

if (!defined('BASE_URL')) {
    define('BASE_URL', '/Mercado_Truchix/');
}

function usuario_logueado() {
    return isset($_SESSION['id_usuario']);
}

function es_admin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}

function requerir_login() {
    if (!usuario_logueado()) {
        header("Location: " . BASE_URL . "auth/login.php");
        exit;
    }
}

function requerir_admin() {
    requerir_login();
    if (!es_admin()) {
        header("Location: " . BASE_URL . "usuario/perfil.php");
        exit;
    }
}
?>