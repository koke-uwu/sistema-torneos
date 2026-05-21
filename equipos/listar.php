<?php
include '../includes/conexion.php';

/** @var mysqli $conn */
$resultado = mysqli_query($conn, "SELECT * FROM equipo");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Equipos</title>
</head>
<body>
    <h1>Lista de Equipos</h1>
    <a href="crear.php">+ Agregar Equipo</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Fecha Creación</th>
            <th>Acciones</th>
        </tr>
        <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= $fila['nombre'] ?></td>
            <td><?= $fila['fecha_creacion'] ?></td>
            <td>
                <a href="editar.php?id=<?= $fila['id'] ?>">Editar</a>
                <a href="eliminar.php?id=<?= $fila['id'] ?>">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>