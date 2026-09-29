<?php
require_once '../config/conexion.php';
require_once '../components/sesion.php';
requerir_login();

$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT u.id_usuario, u.nombre, u.apellido, u.dni, u.email, u.telefono,
               u.fecha_alta, u.ultimo_login, r.nombre AS rol,
               c.id_cuenta, c.alias, c.cvu, c.saldo, c.moneda, c.estado AS estado_cuenta
        FROM usuario u
        JOIN rol r ON r.id_rol = u.id_rol
        LEFT JOIN cuenta c ON c.id_usuario = u.id_usuario
        WHERE u.id_usuario = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();

if (!$u) {
    die("Usuario no encontrado");
}

include '../components/header.php';
?>

<h2>Perfil de <?php echo htmlspecialchars($u['nombre'] . ' ' . $u['apellido']); ?></h2>

<div class="perfil-contenedor">
    <div class="perfil-datos">
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($u['nombre'] . ' ' . $u['apellido']); ?></p>
        <p><strong>DNI:</strong> <?php echo htmlspecialchars($u['dni']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($u['email']); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($u['telefono'] ?? '-'); ?></p>
        <p><strong>Rol:</strong> <?php echo htmlspecialchars($u['rol']); ?></p>
        <p><strong>Fecha de alta:</strong> <?php echo $u['fecha_alta']; ?></p>
        <p><strong>Último login:</strong> <?php echo $u['ultimo_login'] ?? 'Nunca'; ?></p>

        <hr>

        <p><strong>Alias:</strong> <?php echo $u['alias']; ?></p>
        <p><strong>CVU:</strong> <?php echo $u['cvu']; ?></p>
        <p><strong>Saldo:</strong> $<?php echo number_format($u['saldo'], 2, ',', '.'); ?> <?php echo $u['moneda']; ?></p>
        <p><strong>Estado de cuenta:</strong> <?php echo $u['estado_cuenta']; ?></p>
    </div>
</div>

<div class="cards" style="margin-top: 30px;">
    <div class="card">
        <h3>💳</h3>
        <p>Mis transacciones</p>
        <a href="mis_transacciones.php">Ver</a>
    </div>
    <div class="card">
        <h3>📺</h3>
        <p>Mis suscripciones</p>
        <a href="mis_suscripciones.php">Ver</a>
    </div>
    <div class="card">
        <h3>📈</h3>
        <p>Mis inversiones</p>
        <a href="mis_inversiones.php">Ver</a>
    </div>
    <div class="card">
        <h3>💸</h3>
        <p>Transferir dinero</p>
        <a href="../php/transferir.php">Ir</a>
    </div>
    <div class="card">
        <h3>➕</h3>
        <p>Cargar saldo</p>
        <a href="../php/cargar_saldo.php">Ir</a>
    </div>
</div>

<?php
$stmt->close();
$conexion->close();
include '../components/footer.php';
?>