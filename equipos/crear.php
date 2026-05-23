<?php
include '../includes/conexion.php';
/** @var mysqli $conn */

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';
// resto del código...

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitizar la entrada del usuario
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);

    if (!empty($nombre)) {
        // La fecha_creacion se puede insertar automáticamente usando NOW() de MySQL
        $sql = "INSERT INTO equipo (nombre, fecha_creacion) VALUES ('$nombre', NOW())";
        
        if (mysqli_query($conn, $sql)) {
            // Redireccionar a la lista si se guardó con éxito
            header('Location: listar.php'); // Cambia 'listar.php' por el nombre exacto de tu archivo actual
            exit;
        } else {
            $error = "Error al guardar el equipo: " . mysqli_error($conn);
        }
    } else {
        $error = "El nombre del equipo es obligatorio.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Equipo</title>
</head>
<body>
    <h1>Agregar Nuevo Equipo</h1>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="crear.php">
        <label for="nombre">Nombre del Equipo:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>
        <button type="submit">Guardar</button>
        <a href="listar.php">Cancelar</a>
    </form>
</body>
</html>