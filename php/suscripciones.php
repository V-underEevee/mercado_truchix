<?php
require_once '../config/conexion.php';

$suscripciones = $conexion->query("
    SELECT s.id_suscripcion,
           CONCAT(u.nombre, ' ', u.apellido) AS cliente,
           sp.nombre AS servicio,
           ps.nombre_plan,
           ps.precio,
           s.fecha_inicio,
           s.fecha_fin,
           s.estado,
           s.renovacion_automatica
    FROM suscripcion_servicio s
    JOIN usuario u ON u.id_usuario = s.id_usuario
    JOIN plan_servicio ps ON ps.id_plan = s.id_plan
    JOIN servicio_propio sp ON sp.id_servicio = ps.id_servicio
    ORDER BY s.fecha_inicio DESC
");

include_once '../components/header.php';
?>

<h2>Suscripciones</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Servicio</th>
        <th>Plan</th>
        <th>Precio</th>
        <th>Inicio</th>
        <th>Fin</th>
        <th>Estado</th>
        <th>Renovación</th>
    </tr>
    <?php while ($s = $suscripciones->fetch_assoc()): ?>
    <tr>
        <td><?php echo $s['id_suscripcion']; ?></td>
        <td><?php echo htmlspecialchars($s['cliente']); ?></td>
        <td><?php echo htmlspecialchars($s['servicio']); ?></td>
        <td><?php echo htmlspecialchars($s['nombre_plan']); ?></td>
        <td>$<?php echo number_format($s['precio'], 2, ',', '.'); ?></td>
        <td><?php echo $s['fecha_inicio']; ?></td>
        <td><?php echo $s['fecha_fin']; ?></td>
        <td><?php echo $s['estado']; ?></td>
        <td><?php echo $s['renovacion_automatica'] ? 'Sí' : 'No'; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
$conexion->close();
include '../components/footer.php';
?>