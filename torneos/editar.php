<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

$id = $_GET['id'];
$torneo = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM torneo WHERE id=$id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $estado = $_POST['estado'];
    
    mysqli_query($conn, "UPDATE torneo SET nombre='$nombre', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', estado='$estado' WHERE id=$id");
    
    header("Location: listar.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Torneo</title>
</head>
<body>
    <h1>Editar Torneo</h1>
    <a href="listar.php">← Volver</a>
    
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $torneo['nombre'] ?>" required>
        
        <label>Fecha Inicio:</label>
        <input type="date" name="fecha_inicio" value="<?= $torneo['fecha_inicio'] ?>" required>
        
        <label>Fecha Fin:</label>
        <input type="date" name="fecha_fin" value="<?= $torneo['fecha_fin'] ?>" required>
        
        <label>Estado:</label>
        <select name="estado">
            <option value="activo" <?= $torneo['estado'] == 'activo' ? 'selected' : '' ?>>Activo</option>
            <option value="finalizado" <?= $torneo['estado'] == 'finalizado' ? 'selected' : '' ?>>Finalizado</option>
        </select>
        
        <button type="submit">Guardar</button>
    </form>
</body>
</html>