<?php
require_once '../config/conexion.php';

$consumos = $conexion->query("
    SELECT c.id_consumo,
           CONCAT(u.nombre, ' ', u.apellido) AS cliente,
           sp.nombre AS servicio,
           ps.nombre_plan,
           c.descripcion,
           c.monto,
           c.fecha
    FROM consumo_servicio c
    JOIN suscripcion_servicio s ON s.id_suscripcion = c.id_suscripcion
    JOIN usuario u ON u.id_usuario = s.id_usuario
    JOIN plan_servicio ps ON ps.id_plan = s.id_plan
    JOIN servicio_propio sp ON sp.id_servicio = ps.id_servicio
    ORDER BY c.fecha DESC
");

include_once '../components/header.php';
?>

<h2>Consumos de servicios</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Servicio</th>
        <th>Plan</th>
        <th>Descripción</th>
        <th>Monto</th>
        <th>Fecha</th>
    </tr>
    <?php while ($c = $consumos->fetch_assoc()): ?>
    <tr>
        <td><?php echo $c['id_consumo']; ?></td>
        <td><?php echo htmlspecialchars($c['cliente']); ?></td>
        <td><?php echo htmlspecialchars($c['servicio']); ?></td>
        <td><?php echo htmlspecialchars($c['nombre_plan']); ?></td>
        <td><?php echo htmlspecialchars($c['descripcion']); ?></td>
        <td>$<?php echo number_format($c['monto'], 2, ',', '.'); ?></td>
        <td><?php echo $c['fecha']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
$conexion->close();
include '../components/footer.php';
?>