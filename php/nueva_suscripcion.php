<?php
require_once '../config/conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_plan = $_POST['id_plan'];
    $dias = $_POST['dias'];

    $stmt = $conexion->prepare("CALL sp_suscribir_servicio(?, ?, ?)");
    $stmt->bind_param("iii", $id_usuario, $id_plan, $dias);

    if ($stmt->execute()) {
        $r = $stmt->get_result();
        $fila = $r->fetch_assoc();
        $clase = $fila['codigo'] == 0 ? 'mensaje-ok' : 'mensaje-error';
        $mensaje = "<div class='$clase'>" . $fila['mensaje'] . "</div>";
    } else {
        $mensaje = "<div class='mensaje-error'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

$usuarios = $conexion->query("SELECT id_usuario, nombre, apellido FROM usuario WHERE estado = 'activo'");
$planes = $conexion->query("
    SELECT p.id_plan, p.nombre_plan, p.precio, s.nombre AS servicio
    FROM plan_servicio p
    JOIN servicio_propio s ON s.id_servicio = p.id_servicio
    WHERE p.estado = 'activo'
");

include_once '../components/header.php';
?>

<h2>Nueva suscripción</h2>
<?php echo $mensaje; ?>

<form method="POST" action="">
    <label>Usuario:</label>
    <select name="id_usuario" required>
        <option value="">Seleccioná un usuario</option>
        <?php while ($u = $usuarios->fetch_assoc()): ?>
            <option value="<?php echo $u['id_usuario']; ?>">
                <?php echo htmlspecialchars($u['nombre'] . ' ' . $u['apellido']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Plan:</label>
    <select name="id_plan" required>
        <option value="">Seleccioná un plan</option>
        <?php while ($p = $planes->fetch_assoc()): ?>
            <option value="<?php echo $p['id_plan']; ?>">
                <?php echo htmlspecialchars($p['servicio'] . ' - ' . $p['nombre_plan'] . ' ($' . $p['precio'] . ')'); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Días de duración:</label>
    <input type="number" name="dias" value="30" min="1" required>

    <input type="submit" value="Suscribir">
</form>

<?php
$conexion->close();
include '../components/footer.php';
?>