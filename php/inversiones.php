<?php
require_once '../config/conexion.php';

$inversiones = $conexion->query("
    SELECT i.id_inversion,
           CONCAT(u.nombre, ' ', u.apellido) AS cliente,
           ti.nombre AS tipo,
           ti.riesgo,
           ti.tasa_anual,
           i.monto_invertido,
           i.rendimiento_acumulado,
           i.fecha_inicio,
           i.fecha_vencimiento,
           i.estado
    FROM inversion i
    JOIN usuario u ON u.id_usuario = i.id_usuario
    JOIN tipo_inversion ti ON ti.id_tipo_inversion = i.id_tipo_inversion
    ORDER BY i.fecha_inicio DESC
");

include_once '../components/header.php';
?>

<h2>Inversiones</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Tipo</th>
        <th>Riesgo</th>
        <th>Tasa</th>
        <th>Monto</th>
        <th>Rendimiento</th>
        <th>Inicio</th>
        <th>Vencimiento</th>
        <th>Estado</th>
    </tr>
    <?php while ($i = $inversiones->fetch_assoc()): ?>
    <tr>
        <td><?php echo $i['id_inversion']; ?></td>
        <td><?php echo htmlspecialchars($i['cliente']); ?></td>
        <td><?php echo htmlspecialchars($i['tipo']); ?></td>
        <td><?php echo $i['riesgo']; ?></td>
        <td><?php echo $i['tasa_anual']; ?>%</td>
        <td>$<?php echo number_format($i['monto_invertido'], 2, ',', '.'); ?></td>
        <td>$<?php echo number_format($i['rendimiento_acumulado'], 2, ',', '.'); ?></td>
        <td><?php echo $i['fecha_inicio']; ?></td>
        <td><?php echo $i['fecha_vencimiento']; ?></td>
        <td><?php echo $i['estado']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
$conexion->close();
include '../components/footer.php';
?>