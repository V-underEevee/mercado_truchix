<?php
require_once '../config/conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT u.id_usuario, u.nombre, u.apellido, u.password, u.estado, r.nombre AS rol
            FROM usuario u
            JOIN rol r ON r.id_rol = u.id_rol
            WHERE u.email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $u = $resultado->fetch_assoc();

        if ($u['estado'] !== 'activo') {
            $mensaje = "<div class='mensaje-error'>Tu cuenta está " . $u['estado'] . ".</div>";
        } elseif (password_verify($password, $u['password'])) {
            $_SESSION['id_usuario'] = $u['id_usuario'];
            $_SESSION['nombre'] = $u['nombre'];
            $_SESSION['apellido'] = $u['apellido'];
            $_SESSION['rol'] = $u['rol'];

            $upd = $conexion->prepare("UPDATE usuario SET ultimo_login = NOW() WHERE id_usuario = ?");
            $upd->bind_param("i", $u['id_usuario']);
            $upd->execute();
            $upd->close();

            header("Location: " . BASE_URL . "usuario/perfil.php");
            exit;
        } else {
            $mensaje = "<div class='mensaje-error'>Contraseña incorrecta.</div>";
        }
    } else {
        $mensaje = "<div class='mensaje-error'>Usuario no encontrado.</div>";
    }
    $stmt->close();
}

include '../components/header.php';
?>

<h2>Iniciar sesión</h2>
<?php echo $mensaje; ?>

<form method="POST" action="">
    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Contraseña:</label>
    <input type="password" name="password" required>

    <input type="submit" value="Ingresar">
</form>

<p style="margin-top: 15px;">¿No tenés cuenta? <a href="registro.php">Registrate</a></p>

<?php
$conexion->close();
include '../components/footer.php';
?>