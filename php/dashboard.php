<?php
require_once '../config/conexion.php';

$tot_usuarios = $conexion->query("SELECT COUNT(*) AS t FROM usuario")->fetch_assoc()['t'];
$tot_cuentas = $conexion->query("SELECT COUNT(*) AS t FROM cuenta")->fetch_assoc()['t'];
$tot_transacciones = $conexion->query("SELECT COUNT(*) AS t FROM transaccion")->fetch_assoc()['t'];
$tot_saldo = $conexion->query("SELECT SUM(saldo) AS t FROM cuenta")->fetch_assoc()['t'] ?? 0;

$tot_suscripciones = $conexion->query("SELECT COUNT(*) AS t FROM suscripcion_servicio WHERE estado = 'activa'")->fetch_assoc()['t'];
$tot_inversiones = $conexion->query("SELECT COUNT(*) AS t FROM inversion WHERE estado = 'activa'")->fetch_assoc()['t'];
$capital_invertido = $conexion->query("SELECT SUM(monto_invertido) AS t FROM inversion WHERE estado = 'activa'")->fetch_assoc()['t'] ?? 0;
$rendimiento_total = $conexion->query("SELECT SUM(rendimiento_acumulado) AS t FROM inversion")->fetch_assoc()['t'] ?? 0;

$consumo_total = $conexion->query("SELECT SUM(monto) AS t FROM consumo_servicio")->fetch_assoc()['t'] ?? 0;

$servicios_top = $conexion->query("
    SELECT sp.nombre, COUNT(c.id_consumo) AS cant, SUM(c.monto) AS total
    FROM servicio_propio sp
    JOIN plan_servicio ps ON ps.id_servicio = sp.id_servicio
    JOIN suscripcion_servicio s ON s.id_plan = ps.id_plan
    JOIN consumo_servicio c ON c.id_suscripcion = s.id_suscripcion
    GROUP BY sp.nombre
    ORDER BY total DESC
    LIMIT 3
");

$ultimas_transacciones = $conexion->query("
    SELECT t.id_transaccion, t.tipo, t.monto, t.fecha, t.estado,
           co.alias AS origen, cd.alias AS destino
    FROM transaccion t
    LEFT JOIN cuenta co ON co.id_cuenta = t.id_cuenta_origen
    LEFT JOIN cuenta cd ON cd.id_cuenta = t.id_cuenta_destino
    ORDER BY t.fecha DESC
    LIMIT 5
");

$inversiones_por_riesgo = $conexion->query("
    SELECT ti.riesgo,
           COUNT(i.id_inversion) AS cant,
           SUM(i.monto_invertido) AS total
    FROM inversion i
    JOIN tipo_inversion ti ON ti.id_tipo_inversion = i.id_tipo_inversion
    GROUP BY ti.riesgo
");

include_once '../components/header.php';
?>

<h2>Dashboard de métricas</h2>

<div class="cards">
    <div class="card">
        <h3><?php echo $tot_usuarios; ?></h3>
        <p>Usuarios registrados</p>
    </div>
    <div class="card">
        <h3><?php echo $tot_cuentas; ?></h3>
        <p>Cuentas creadas</p>
    </div>
    <div class="card">
        <h3><?php echo $tot_transacciones; ?></h3>
        <p>Transacciones totales</p>
    </div>
    <div class="card">
        <h3>$<?php echo number_format($tot_saldo, 2, ',', '.'); ?></h3>
        <p>Saldo total en el sistema</p>
    </div>
</div>

<div class="cards">
    <div class="card">
        <h3><?php echo $tot_suscripciones; ?></h3>
        <p>Suscripciones activas</p>
    </div>
    <div class="card">
        <h3><?php echo $tot_inversiones; ?></h3>
        <p>Inversiones activas</p>
    </div>
    <div class="card">
        <h3>$<?php echo number_format($capital_invertido, 2, ',', '.'); ?></h3>
        <p>Capital invertido</p>
    </div>
    <div class="card">
        <h3>$<?php echo number_format($rendimiento_total, 2, ',', '.'); ?></h3>
        <p>Rendimiento acumulado</p>
    </div>
</div>

<div class="cards">
    <div class="card">
        <h3>$<?php echo number_format($consumo_total, 2, ',', '.'); ?></h3>
        <p>Consumo total en servicios</p>
    </div>
</div>

<h3>Top 3 servicios por facturación</h3>
<table>
    <tr>
        <th>Servicio</th>
        <th>Consumos</th>
        <th>Total facturado</th>
    </tr>
    <?php while ($s = $servicios_top->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($s['nombre']); ?></td>
        <td><?php echo $s['cant']; ?></td>
        <td>$<?php echo number_format($s['total'], 2, ',', '.'); ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<h3>Últimas 5 transacciones</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Tipo</th>
        <th>Origen</th>
        <th>Destino</th>
        <th>Monto</th>
        <th>Fecha</th>
        <th>Estado</th>
    </tr>
    <?php while ($t = $ultimas_transacciones->fetch_assoc()): ?>
    <tr>
        <td><?php echo $t['id_transaccion']; ?></td>
        <td><?php echo $t['tipo']; ?></td>
        <td><?php echo $t['origen'] ?? '-'; ?></td>
        <td><?php echo $t['destino'] ?? '-'; ?></td>
        <td>$<?php echo number_format($t['monto'], 2, ',', '.'); ?></td>
        <td><?php echo $t['fecha']; ?></td>
        <td><?php echo $t['estado']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<h3>Inversiones por nivel de riesgo</h3>
<table>
    <tr>
        <th>Riesgo</th>
        <th>Cantidad</th>
        <th>Capital total</th>
    </tr>
    <?php while ($r = $inversiones_por_riesgo->fetch_assoc()): ?>
    <tr>
        <td><?php echo $r['riesgo']; ?></td>
        <td><?php echo $r['cant']; ?></td>
        <td>$<?php echo number_format($r['total'], 2, ',', '.'); ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
$conexion->close();
include '../components/footer.php';
?>