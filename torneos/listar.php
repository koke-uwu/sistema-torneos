<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

$resultado = mysqli_query($conn, "SELECT * FROM torneo");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Torneos</title>
</head>
<body>
    <h1>Lista de Torneos</h1>
    <a href="crear.php">+ Agregar Torneo</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= $fila['nombre'] ?></td>
            <td><?= $fila['fecha_inicio'] ?></td>
            <td><?= $fila['fecha_fin'] ?></td>
            <td><?= $fila['estado'] ?></td>
            <td>
                <a href="editar.php?id=<?= $fila['id'] ?>">Editar</a>
                <a href="eliminar.php?id=<?= $fila['id'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>