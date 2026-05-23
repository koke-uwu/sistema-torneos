<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

$resultado = mysqli_query($conn, "SELECT p.*, e1.nombre as local, e2.nombre as visitante, t.nombre as torneo FROM partido p JOIN equipo e1 ON p.id_equipo_local = e1.id JOIN equipo e2 ON p.id_equipo_visitante = e2.id JOIN torneo t ON p.id_torneo = t.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Partidos</title>
</head>
<body>
    <h1>Lista de Partidos</h1>
    <a href="crear.php">+ Agregar Partido</a>
    <table border="1">
        <tr>
            <th>Torneo</th>
            <th>Local</th>
            <th>Visitante</th>
            <th>Resultado</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?= $fila['torneo'] ?></td>
            <td><?= $fila['local'] ?></td>
            <td><?= $fila['visitante'] ?></td>
            <td><?= $fila['goles_local'] ?> - <?= $fila['goles_visitante'] ?></td>
            <td><?= $fila['fecha'] ?></td>
            <td>
                <a href="editar.php?id=<?= $fila['id'] ?>">Editar</a>
                <a href="eliminar.php?id=<?= $fila['id'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>