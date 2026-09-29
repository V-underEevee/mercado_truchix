<?php
require_once '../config/conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($conexion->query("CALL sp_aplicar_rendimiento_a_todas()")) {
        $mensaje = "<div class='mensaje-ok'>Rendimientos aplicados correctamente a todas las inversiones activas.</div>";
    } else {
        $mensaje = "<div class='mensaje-error'>Error: " . $conexion->error . "</div>";
    }
}

include_once '../components/header.php';
?>

<h2>Aplicar rendimientos</h2>
<?php echo $mensaje; ?>

<p>Esta acción recorre todas las inversiones activas y les suma el rendimiento correspondiente al último mes.</p>

<form method="POST" action="">
    <input type="submit" value="Aplicar rendimientos ahora">
</form>

<?php
$conexion->close();
include '../components/footer.php';
?>