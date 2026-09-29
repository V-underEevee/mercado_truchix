<?php
require_once '../config/conexion.php';

$servicios = $conexion->query("
    SELECT id_servicio, nombre, tipo, descripcion, precio_mensual, comision_porcentaje, fecha_lanzamiento, estado
    FROM servicio_propio
    ORDER BY id_servicio
");

include_once '../components/header.php';
?>

<h2>Servicios de Mercado Truchix</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Precio mensual</th>
        <th>Comisión %</th>
        <th>Lanzamiento</th>
        <th>Estado</th>
    </tr>
    <?php while ($s = $servicios->fetch_assoc()): ?>
    <tr>
        <td><?php echo $s['id_servicio']; ?></td>
        <td><?php echo htmlspecialchars($s['nombre']); ?></td>
        <td><?php echo $s['tipo']; ?></td>
        <td><?php echo htmlspecialchars($s['descripcion']); ?></td>
        <td>$<?php echo number_format($s['precio_mensual'], 2, ',', '.'); ?></td>
        <td><?php echo $s['comision_porcentaje']; ?>%</td>
        <td><?php echo $s['fecha_lanzamiento']; ?></td>
        <td><?php echo $s['estado']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
$conexion->close();
include '../components/footer.php';
?>