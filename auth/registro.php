<?php
require_once '../config/conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $dni = trim($_POST['dni']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password !== $password2) {
        $mensaje = "<div class='mensaje-error'>Las contraseñas no coinciden.</div>";
    } else {
        $check = $conexion->prepare("SELECT id_usuario FROM usuario WHERE email = ? OR dni = ?");
        $check->bind_param("ss", $email, $dni);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $mensaje = "<div class='mensaje-error'>El email o DNI ya están registrados.</div>";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuario (nombre, apellido, dni, email, telefono, password, id_rol) 
                    VALUES (?, ?, ?, ?, ?, ?, 2)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssssss", $nombre, $apellido, $dni, $email, $telefono, $hash);

            if ($stmt->execute()) {
                $id = $stmt->insert_id;
                $cvu = str_pad($id, 22, "0", STR_PAD_LEFT);
                $alias = strtolower($nombre) . "." . strtolower($apellido) . "." . $id;

                $sql2 = "INSERT INTO cuenta (id_usuario, cvu, alias, saldo) VALUES (?, ?, ?, 0.00)";
                $stmt2 = $conexion->prepare($sql2);
                $stmt2->bind_param("iss", $id, $cvu, $alias);
                $stmt2->execute();
                $stmt2->close();

                $mensaje = "<div class='mensaje-ok'>Registro exitoso. <a href='login.php'>Iniciá sesión</a></div>";
            } else {
                $mensaje = "<div class='mensaje-error'>Error: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
        $check->close();
    }
}

include '../components/header.php';
?>

<h2>Crear cuenta</h2>
<?php echo $mensaje; ?>

<form method="POST" action="">
    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Apellido:</label>
    <input type="text" name="apellido" required>

    <label>DNI:</label>
    <input type="text" name="dni" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Teléfono:</label>
    <input type="text" name="telefono">

    <label>Contraseña:</label>
    <input type="password" name="password" required>

    <label>Repetir contraseña:</label>
    <input type="password" name="password2" required>

    <input type="submit" value="Registrarme">
</form>

<?php
$conexion->close();
include '../components/footer.php';
?>