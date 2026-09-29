<?php
require_once '../config/conexion.php';

$servicios = $conexion->query("SELECT * FROM v_ingresos_por_servicio");
$ranking = $conexion->query("SELECT * FROM v_ranking_inversiones");
$mas_consumidos = $conexion->query("SELECT * FROM v_servicios_mas_consumidos");

include_once '../components/header.php';
?>

<h2>Reportes generales</h2>

<h3>Ingresos por servicio</h3>
<table>
    <tr>
        <th>Servicio</th>
        <th>Tipo</th>
        <th>Consumos</th>
        <th>Total facturado</th>
        <th>Promedio</th>
    </tr>
    <?php while ($s = $servicios->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($s['nombre']); ?></td>
        <td><?php echo $s['tipo']; ?></td>
        <td><?php echo $s['cant_consumos']; ?></td>
        <td>$<?php echo number_format($s['total_facturado'], 2, ',', '.'); ?></td>
        <td>$<?php echo number_format($s['promedio_consumo'], 2, ',', '.'); ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<h3>Ranking de inversiones</h3>
<table>
    <tr>
        <th>Tipo</th>
        <th>Riesgo</th>
        <th>Tasa anual</th>
        <th>Cantidad</th>
        <th>Capital total</th>
        <th>Rendimiento promedio</th>
    </tr>
    <?php while ($r = $ranking->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($r['nombre']); ?></td>
        <td><?php echo $r['riesgo']; ?></td>
        <td><?php echo $r['tasa_anual']; ?>%</td>
        <td><?php echo $r['cant_inversiones']; ?></td>
        <td>$<?php echo number_format($r['capital_total'], 2, ',', '.'); ?></td>
        <td>$<?php echo number_format($r['rendimiento_promedio'], 2, ',', '.'); ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<h3>Servicios más consumidos</h3>
<table>
    <tr>
        <th>Servicio</th>
        <th>Plan</th>
        <th>Consumos</th>
        <th>Total gastado</th>
    </tr>
    <?php while ($m = $mas_consumidos->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($m['servicio']); ?></td>
        <td><?php echo htmlspecialchars($m['nombre_plan']); ?></td>
        <td><?php echo $m['cant_consumos']; ?></td>
        <td>$<?php echo number_format($m['total_gastado'], 2, ',', '.'); ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
$conexion->close();
include '../components/footer.php';
?>