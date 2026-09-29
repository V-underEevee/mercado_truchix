<?php
require_once '../config/conexion.php';
require_once '../components/sesion.php';
requerir_login();
$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT i.id_inversion, ti.nombre AS tipo, ti.riesgo, ti.tasa_anual,
               i.monto_invertido, i.rendimiento_acumulado,
               i.fecha_inicio, i.fecha_vencimiento, i.estado
        FROM inversion i
        JOIN tipo_inversion ti ON ti.id_tipo_inversion = i.id_tipo_inversion
        WHERE i.id_usuario = ?
        ORDER BY i.fecha_inicio DESC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$inversiones = $stmt->get_result();

$sql_mov = "SELECT m.id_movimiento, m.tipo, m.monto, m.fecha, ti.nombre AS inversion
            FROM movimiento_inversion m
            JOIN inversion i ON i.id_inversion = m.id_inversion
            JOIN tipo_inversion ti ON ti.id_tipo_inversion = i.id_tipo_inversion
            WHERE i.id_usuario = ?
            ORDER BY m.fecha DESC
            LIMIT 10";

$stmt2 = $conexion->prepare($sql_mov);
$stmt2->bind_param("i", $id_usuario);
$stmt2->execute();
$movimientos = $stmt2->get_result();

include_once '../components/header.php';
?>

<h2>Mis inversiones</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Tipo</th>
        <th>Riesgo</th>
        <th>Tasa anual</th>
        <th>Monto invertido</th>
        <th>Rendimiento</th>
        <th>Inicio</th>
        <th>Vencimiento</th>
        <th>Estado</th>
    </tr>
    <?php while ($i = $inversiones->fetch_assoc()): ?>
    <tr>
        <td><?php echo $i['id_inversion']; ?></td>
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

<h3 style="margin-top: 30px;">Últimos movimientos</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Inversión</th>
        <th>Tipo</th>
        <th>Monto</th>
        <th>Fecha</th>
    </tr>
    <?php while ($m = $movimientos->fetch_assoc()): ?>
    <tr>
        <td><?php echo $m['id_movimiento']; ?></td>
        <td><?php echo htmlspecialchars($m['inversion']); ?></td>
        <td><?php echo $m['tipo']; ?></td>
        <td>$<?php echo number_format($m['monto'], 2, ',', '.'); ?></td>
        <td><?php echo $m['fecha']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<p style="margin-top: 20px;"><a href="perfil.php?id=<?php echo $id_usuario; ?>">← Volver al perfil</a></p>

<?php
$stmt->close();
$stmt2->close();
$conexion->close();
include '../components/footer.php';
?>