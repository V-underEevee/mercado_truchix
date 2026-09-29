<?php
require_once '../config/conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_suscripcion = $_POST['id_suscripcion'];

    $stmt = $conexion->prepare("CALL sp_cancelar_suscripcion(?)");
    $stmt->bind_param("i", $id_suscripcion);

    if ($stmt->execute()) {
        $r = $stmt->get_result();
        $fila = $r->fetch_assoc();
        $mensaje = "<div class='mensaje-ok'>" . ($fila['mensaje'] ?? 'Suscripción cancelada') . "</div>";
    } else {
        $mensaje = "<div class='mensaje-error'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

$activas = $conexion->query("
    SELECT s.id_suscripcion,
           CONCAT(u.nombre, ' ', u.apellido) AS cliente,
           sp.nombre AS servicio,
           ps.nombre_plan
    FROM suscripcion_servicio s
    JOIN usuario u ON u.id_usuario = s.id_usuario
    JOIN plan_servicio ps ON ps.id_plan = s.id_plan
    JOIN servicio_propio sp ON sp.id_servicio = ps.id_servicio
    WHERE s.estado = 'activa'
");

include_once '../components/header.php';
?>

<h2>Cancelar suscripción</h2>
<?php echo $mensaje; ?>

<form method="POST" action="">
    <label>Suscripción activa:</label>
    <select name="id_suscripcion" required>
        <option value="">Seleccioná una suscripción</option>
        <?php while ($s = $activas->fetch_assoc()): ?>
            <option value="<?php echo $s['id_suscripcion']; ?>">
                <?php echo htmlspecialchars($s['cliente'] . ' - ' . $s['servicio'] . ' (' . $s['nombre_plan'] . ')'); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="submit" value="Cancelar suscripción">
</form>

<?php
$conexion->close();
include '../components/footer.php';
?>