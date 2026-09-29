<?php
require_once '../config/conexion.php';

$tipos = $conexion->query("
    SELECT id_tipo_inversion, nombre, riesgo, tasa_anual, descripcion, estado
    FROM tipo_inversion
    ORDER BY tasa_anual DESC
");

include_once '../components/header.php';
?>

<h2>Tipos de inversión</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Riesgo</th>
        <th>Tasa anual</th>
        <th>Descripción</th>
        <th>Estado</th>
    </tr>
    <?php while ($t = $tipos->fetch_assoc()): ?>
    <tr>
        <td><?php echo $t['id_tipo_inversion']; ?></td>
        <td><?php echo htmlspecialchars($t['nombre']); ?></td>
        <td><?php echo $t['riesgo']; ?></td>
        <td><?php echo $t['tasa_anual']; ?>%</td>
        <td><?php echo htmlspecialchars($t['descripcion']); ?></td>
        <td><?php echo $t['estado']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
$conexion->close();
include '../components/footer.php';
?>