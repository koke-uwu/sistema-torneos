<?php
include 'includes/conexion.php';

$id_torneo = $_GET['id'];

$torneo = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM torneo WHERE id=$id_torneo"));

// Consulta que calcula la tabla de posiciones
$sql = "
SELECT 
    e.id,
    e.nombre,
    COUNT(CASE WHEN p.jugado = 1 THEN 1 END) as pj,
    COUNT(CASE WHEN (p.id_equipo_local = e.id AND p.goles_local > p.goles_visitante) OR (p.id_equipo_visitante = e.id AND p.goles_visitante > p.goles_local) AND p.jugado = 1 THEN 1 END) as g,
    COUNT(CASE WHEN p.goles_local = p.goles_visitante AND p.jugado = 1 THEN 1 END) as e_,
    COUNT(CASE WHEN (p.id_equipo_local = e.id AND p.goles_local < p.goles_visitante) OR (p.id_equipo_visitante = e.id AND p.goles_visitante < p.goles_local) AND p.jugado = 1 THEN 1 END) as p,
    SUM(CASE WHEN p.id_equipo_local = e.id THEN p.goles_local WHEN p.id_equipo_visitante = e.id THEN p.goles_visitante ELSE 0 END) as gf,
    SUM(CASE WHEN p.id_equipo_local = e.id THEN p.goles_visitante WHEN p.id_equipo_visitante = e.id THEN p.goles_local ELSE 0 END) as gc,
    (COUNT(CASE WHEN (p.id_equipo_local = e.id AND p.goles_local > p.goles_visitante) OR (p.id_equipo_visitante = e.id AND p.goles_visitante > p.goles_local) AND p.jugado = 1 THEN 1 END) * 3) +
    COUNT(CASE WHEN p.goles_local = p.goles_visitante AND p.jugado = 1 THEN 1 END) as pts
FROM equipo e
LEFT JOIN partido p ON (p.id_equipo_local = e.id OR p.id_equipo_visitante = e.id) AND p.id_torneo = $id_torneo
GROUP BY e.id, e.nombre
ORDER BY pts DESC, gf DESC
";

$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $torneo['nombre'] ?></title>
</head>
<body>
    <h1><?= $torneo['nombre'] ?></h1>
    <a href="index.php">← Volver</a>
    
    <h2>Tabla de Posiciones</h2>
    <table border="1">
        <tr>
            <th>Equipo</th>
            <th>PJ</th>
            <th>G</th>
            <th>E</th>
            <th>P</th>
            <th>GF</th>
            <th>GC</th>
            <th>DG</th>
            <th>Pts</th>
        </tr>
        <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?= $fila['nombre'] ?></td>
            <td><?= $fila['pj'] ?></td>
            <td><?= $fila['g'] ?></td>
            <td><?= $fila['e_'] ?></td>
            <td><?= $fila['p'] ?></td>
            <td><?= $fila['gf'] ?></td>
            <td><?= $fila['gc'] ?></td>
            <td><?= ($fila['gf'] - $fila['gc']) ?></td>
            <td><?= $fila['pts'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>