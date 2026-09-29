<?php
require_once __DIR__ . '/sesion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mercado Truchix</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
    <header>
        <a href="<?php echo BASE_URL; ?>index.php">
            <img src="<?php echo BASE_URL; ?>img/Mercado_Truchix.png" alt="Mercado Truchix" class="logo">
        </a>

        <?php if (usuario_logueado()): ?>
            <p class="bienvenida">Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?> 👋</p>
        <?php endif; ?>

        <nav>
            <!-- <a href="<?php echo BASE_URL; ?>index.php">Inicio</a> -->

            <?php if (usuario_logueado()): ?>
                <a href="<?php echo BASE_URL; ?>usuario/perfil.php">Mi perfil</a>
                <a href="<?php echo BASE_URL; ?>usuario/mis_transacciones.php">Mis transacciones</a>
                <a href="<?php echo BASE_URL; ?>usuario/mis_suscripciones.php">Mis suscripciones</a>
                <a href="<?php echo BASE_URL; ?>usuario/mis_inversiones.php">Mis inversiones</a>
                <a href="<?php echo BASE_URL; ?>php/transferir.php">Transferir</a>
                <a href="<?php echo BASE_URL; ?>php/cargar_saldo.php">Cargar saldo</a>
                <a href="<?php echo BASE_URL; ?>auth/logout.php" class="btn-salir">Cerrar sesión</a>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>auth/login.php">Ingresar</a>
                <a href="<?php echo BASE_URL; ?>auth/registro.php">Registrarme</a>
            <?php endif; ?>
        </nav>

        <?php if (usuario_logueado() && es_admin()): ?>
            <nav class="nav-admin">
                <span class="etiqueta-admin">Admin</span>
                <a href="<?php echo BASE_URL; ?>php/dashboard.php">Dashboard</a>
                <a href="<?php echo BASE_URL; ?>php/listar_usuarios.php">Usuarios</a>
                <a href="<?php echo BASE_URL; ?>php/listar_cuentas.php">Cuentas</a>
                <a href="<?php echo BASE_URL; ?>php/servicios.php">Servicios</a>
                <a href="<?php echo BASE_URL; ?>php/planes.php">Planes</a>
                <a href="<?php echo BASE_URL; ?>php/suscripciones.php">Suscripciones</a>
                <a href="<?php echo BASE_URL; ?>php/tipos_inversion.php">Tipos de Inversión</a>
                <a href="<?php echo BASE_URL; ?>php/inversiones.php">Inversiones</a>
                <a href="<?php echo BASE_URL; ?>php/reportes.php">Reportes</a>
            </nav>
        <?php endif; ?>
    </header>
    <main>