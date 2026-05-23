<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel de Control</title>
</head>
<body>
    <h1>Bienvenido <?= $_SESSION['usuario'] ?></h1>
    
    <ul>
        <li><a href="../equipos/listar.php">Gestionar Equipos</a></li>
        <li><a href="../jugadores/listar.php">Gestionar Jugadores</a></li>
        <li><a href="../torneos/listar.php">Gestionar Torneos</a></li>
        <li><a href="../partidos/listar.php">Gestionar Partidos</a></li>
        <li><a href="logout.php">Cerrar Sesión</a></li>
    </ul>
</body>
</html>