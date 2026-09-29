<?php
require_once '../config/conexion.php';

require_once '../components/sesion.php';
requerir_login();
$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT t.id_transaccion, t.tipo, t.monto, t.moneda, t.fecha, t.estado,
               co.alias AS origen, cd.alias AS destino, t.descripcion
        FROM transaccion t
        LEFT JOIN cuenta co ON co.id_cuenta = t.id_cuenta_origen
        LEFT JOIN cuenta cd ON cd.id_cuenta = t.id_cuenta_destino
        WHERE t.id_cuenta_origen IN (SELECT id_cuenta FROM cuenta WHERE id_usuario = ?)
           OR t.id_cuenta_destino IN (SELECT id_cuenta FROM cuenta WHERE id_usuario = ?)
        ORDER BY t.fecha DESC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $id_usuario, $id_usuario);
$stmt->execute();
$transacciones = $stmt->get_result();

include_once '../components/header.php';
?>

<h2>Mis transacciones</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Tipo</th>
        <th>Origen</th>
        <th>Destino</th>
        <th>Monto</th>
        <th>Moneda</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Descripción</th>
    </tr>
    <?php while ($t = $transacciones->fetch_assoc()): ?>
    <tr>
        <td><?php echo $t['id_transaccion']; ?></td>
        <td><?php echo $t['tipo']; ?></td>
        <td><?php echo $t['origen'] ?? '-'; ?></td>
        <td><?php echo $t['destino'] ?? '-'; ?></td>
        <td>$<?php echo number_format($t['monto'], 2, ',', '.'); ?></td>
        <td><?php echo $t['moneda']; ?></td>
        <td><?php echo $t['fecha']; ?></td>
        <td><?php echo $t['estado']; ?></td>
        <td><?php echo htmlspecialchars($t['descripcion'] ?? ''); ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<p style="margin-top: 20px;"><a href="perfil.php?id=<?php echo $id_usuario; ?>">← Volver al perfil</a></p>

<?php
$stmt->close();
$conexion->close();
include '../components/footer.php';
?>