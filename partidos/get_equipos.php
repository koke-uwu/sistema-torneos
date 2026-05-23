<?php
include '../includes/conexion.php';

$id_torneo = $_GET['id'];

$sql = "SELECT e.* FROM equipo e INNER JOIN torneo_equipo te ON e.id = te.id_equipo WHERE te.id_torneo = $id_torneo";
$resultado = mysqli_query($conn, $sql);

$equipos = [];
while($fila = mysqli_fetch_assoc($resultado)) {
    $equipos[] = $fila;
}

echo json_encode($equipos);
?>