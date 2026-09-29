<?php
require_once '../config/conexion.php';

require_once '../components/sesion.php';
requerir_login();
$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT c.id_consumo, sp.nombre AS servicio, ps.nombre_plan,
               c.descripcion, c.monto, c.fecha
        FROM consumo_servicio c
        JOIN suscripcion_servicio s ON s.id_suscripcion = c.id_suscripcion
        JOIN plan_servicio ps ON ps.id_plan = s.id_plan
        JOIN servicio_propio sp ON sp.id_servicio = ps.id_servicio
        WHERE s.id_usuario = ?
        ORDER BY c.fecha DESC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$consumos = $stmt->get_result();

include_once '../components/header.php';
?>

<h2>Mis consumos de servicios</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Servicio</th>
        <th>Plan</th>
        <th>Descripción</th>
        <th>Monto</th>
        <th>Fecha</th>
    </tr>
    <?php while ($c = $consumos->fetch_assoc()): ?>
    <tr>
        <td><?php echo $c['id_consumo']; ?></td>
        <td><?php echo htmlspecialchars($c['servicio']); ?></td>
        <td><?php echo htmlspecialchars($c['nombre_plan']); ?></td>
        <td><?php echo htmlspecialchars($c['descripcion']); ?></td>
        <td>$<?php echo number_format($c['monto'], 2, ',', '.'); ?></td>
        <td><?php echo $c['fecha']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<p style="margin-top: 20px;"><a href="perfil.php?id=<?php echo $id_usuario; ?>">← Volver al perfil</a></p>

<?php
$stmt->close();
$conexion->close();
include '../components/footer.php';
?>