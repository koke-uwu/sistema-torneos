<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    
    $sql = "INSERT INTO torneo (nombre, fecha_inicio, fecha_fin, estado) VALUES ('$nombre', '$fecha_inicio', '$fecha_fin', 'activo')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: listar.php");
    } else {
        $error = "Error al crear el torneo";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Torneo</title>
</head>
<body>
    <h1>Crear Nuevo Torneo</h1>
    <a href="listar.php">← Volver</a>
    
    <?php if(isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        
        <label>Fecha Inicio:</label>
        <input type="date" name="fecha_inicio" required>
        
        <label>Fecha Fin:</label>
        <input type="date" name="fecha_fin" required>
        
        <button type="submit">Crear Torneo</button>
    </form>
</body>
</html>