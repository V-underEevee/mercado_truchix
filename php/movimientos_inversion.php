<?php
require_once '../config/conexion.php';

$movimientos = $conexion->query("
    SELECT m.id_movimiento,
           CONCAT(u.nombre, ' ', u.apellido) AS cliente,
           ti.nombre AS tipo_inversion,
           m.tipo,
           m.monto,
           m.fecha
    FROM movimiento_inversion m
    JOIN inversion i ON i.id_inversion = m.id_inversion
    JOIN usuario u ON u.id_usuario = i.id_usuario
    JOIN tipo_inversion ti ON ti.id_tipo_inversion = i.id_tipo_inversion
    ORDER BY m.fecha DESC
");

include_once '../components/header.php';
?>

<h2>Movimientos de inversión</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Tipo inversión</th>
        <th>Movimiento</th>
        <th>Monto</th>
        <th>Fecha</th>
    </tr>
    <?php while ($m = $movimientos->fetch_assoc()): ?>
    <tr>
        <td><?php echo $m['id_movimiento']; ?></td>
        <td><?php echo htmlspecialchars($m['cliente']); ?></td>
        <td><?php echo htmlspecialchars($m['tipo_inversion']); ?></td>
        <td><?php echo $m['tipo']; ?></td>
        <td>$<?php echo number_format($m['monto'], 2, ',', '.'); ?></td>
        <td><?php echo $m['fecha']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
$conexion->close();
include '../components/footer.php';
?>