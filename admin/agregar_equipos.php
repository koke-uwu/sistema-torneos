<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

$id_torneo = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_equipo = $_POST['id_equipo'];
    
    $sql = "INSERT INTO torneo_equipo (id_torneo, id_equipo) VALUES ($id_torneo, $id_equipo)";
    mysqli_query($conn, $sql);
    
    header("Location: agregar_equipos.php?id=$id_torneo");
}

$equipos_disponibles = mysqli_query($conn, "SELECT * FROM equipo WHERE id NOT IN (SELECT id_equipo FROM torneo_equipo WHERE id_torneo = $id_torneo)");

$equipos_agregados = mysqli_query($conn, "SELECT e.* FROM equipo e INNER JOIN torneo_equipo te ON e.id = te.id_equipo WHERE te.id_torneo = $id_torneo");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Equipos al Torneo</title>
</head>
<body>
    <h1>Equipos en el Torneo</h1>
    <a href="../admin/dashboard.php">← Volver</a>
    
    <h2>Equipos Agregados</h2>
    <ul>
        <?php while($equipo = mysqli_fetch_assoc($equipos_agregados)): ?>
            <li><?= $equipo['nombre'] ?></li>
        <?php endwhile; ?>
    </ul>
    
    <h2>Agregar Equipos</h2>
    <form method="POST">
        <select name="id_equipo" required>
            <option value="">Seleccionar Equipo</option>
            <?php while($equipo = mysqli_fetch_assoc($equipos_disponibles)): ?>
                <option value="<?= $equipo['id'] ?>"><?= $equipo['nombre'] ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Agregar</button>
    </form>
</body>
</html>