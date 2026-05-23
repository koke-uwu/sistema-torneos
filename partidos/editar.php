<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

$id = $_GET['id'];
$partido = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM partido WHERE id=$id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $goles_local = $_POST['goles_local'];
    $goles_visitante = $_POST['goles_visitante'];
    $jugado = isset($_POST['jugado']) ? 1 : 0;
    
    $sql = "UPDATE partido SET goles_local=$goles_local, goles_visitante=$goles_visitante, jugado=$jugado WHERE id=$id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: listar.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Partido</title>
</head>
<body>
    <h1>Editar Partido</h1>
    <a href="listar.php">← Volver</a>
    
    <form method="POST">
        <label>Goles Local:</label>
        <input type="number" name="goles_local" value="<?= $partido['goles_local'] ?>">
        
        <label>Goles Visitante:</label>
        <input type="number" name="goles_visitante" value="<?= $partido['goles_visitante'] ?>">
        
        <label>
            <input type="checkbox" name="jugado" <?= $partido['jugado'] ? 'checked' : '' ?>> Partido Jugado
        </label>
        
        <button type="submit">Guardar</button>
    </form>
</body>
</html>