<?php
require_once '../config/conexion.php';

require_once '../components/sesion.php';
requerir_login();
$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT s.id_suscripcion, sp.nombre AS servicio, ps.nombre_plan, ps.precio,
               s.fecha_inicio, s.fecha_fin, s.estado, s.renovacion_automatica
        FROM suscripcion_servicio s
        JOIN plan_servicio ps ON ps.id_plan = s.id_plan
        JOIN servicio_propio sp ON sp.id_servicio = ps.id_servicio
        WHERE s.id_usuario = ?
        ORDER BY s.fecha_inicio DESC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$suscripciones = $stmt->get_result();

include_once '../components/header.php';
?>

<h2>Mis suscripciones</h2>

<table>
    <tr>
        <th>ID</th>
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

<p style="margin-top: 20px;"><a href="perfil.php?id=<?php echo $id_usuario; ?>">← Volver al perfil</a></p>

<?php
$stmt->close();
$conexion->close();
include '../components/footer.php';
?>