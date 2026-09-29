<?php
require_once '../config/conexion.php';

session_unset();
session_destroy();

header("Location: " . BASE_URL . "auth/login.php");
exit;
?>