<?php
require_once '../config/conexion.php';

$planes = $conexion->query("
    SELECT p.id_plan, s.nombre AS servicio, s.tipo,
           p.nombre_plan, p.precio, p.duracion_dias, p.limite_uso, p.descripcion, p.estado
    FROM plan_servicio p
    JOIN servicio_propio s ON s.id_servicio = p.id_servicio
    ORDER BY s.nombre, p.precio
");

include_once '../components/header.php';
?>

<h2>Planes disponibles</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Servicio</th>
        <th>Tipo</th>
        <th>Plan</th>
        <th>Precio</th>
        <th>Duración</th>
        <th>Límite uso</th>
        <th>Descripción</th>
        <th>Estado</th>
    </tr>
    <?php while ($p = $planes->fetch_assoc()): ?>
    <tr>
        <td><?php echo $p['id_plan']; ?></td>
        <td><?php echo htmlspecialchars($p['servicio']); ?></td>
        <td><?php echo $p['tipo']; ?></td>
        <td><?php echo htmlspecialchars($p['nombre_plan']); ?></td>
        <td>$<?php echo number_format($p['precio'], 2, ',', '.'); ?></td>
        <td><?php echo $p['duracion_dias']; ?> días</td>
        <td><?php echo $p['limite_uso'] == 0 ? 'Ilimitado' : $p['limite_uso']; ?></td>
        <td><?php echo htmlspecialchars($p['descripcion']); ?></td>
        <td><?php echo $p['estado']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
$conexion->close();
include '../components/footer.php';
?>