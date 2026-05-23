<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_torneo = $_POST['id_torneo'];
    $id_equipo_local = $_POST['id_equipo_local'];
    $id_equipo_visitante = $_POST['id_equipo_visitante'];
    $goles_local = $_POST['goles_local'];
    $goles_visitante = $_POST['goles_visitante'];
    $fecha = $_POST['fecha'];
    $jugado = isset($_POST['jugado']) ? 1 : 0;
    
    $sql = "INSERT INTO partido (id_torneo, id_equipo_local, id_equipo_visitante, goles_local, goles_visitante, fecha, jugado) 
            VALUES ($id_torneo, $id_equipo_local, $id_equipo_visitante, $goles_local, $goles_visitante, '$fecha', $jugado)";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: listar.php");
    } else {
        $error = "Error al crear partido";
    }
}

$torneos = mysqli_query($conn, "SELECT * FROM torneo");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Partido</title>
</head>
<body>
    <h1>Crear Partido</h1>
    <a href="listar.php">← Volver</a>
    
    <?php if(isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label>Torneo:</label>
        <select name="id_torneo" required onchange="cargarEquipos(this.value)">
            <option value="">Seleccionar Torneo</option>
            <?php while($torneo = mysqli_fetch_assoc($torneos)): ?>
                <option value="<?= $torneo['id'] ?>"><?= $torneo['nombre'] ?></option>
            <?php endwhile; ?>
        </select>
        
        <label>Equipo Local:</label>
        <select name="id_equipo_local" id="local" required>
            <option value="">Seleccionar</option>
        </select>
        
        <label>Equipo Visitante:</label>
        <select name="id_equipo_visitante" id="visitante" required>
            <option value="">Seleccionar</option>
        </select>
        
        <label>Goles Local:</label>
        <input type="number" name="goles_local" value="0">
        
        <label>Goles Visitante:</label>
        <input type="number" name="goles_visitante" value="0">
        
        <label>Fecha:</label>
        <input type="date" name="fecha" required>
        
        <label>
            <input type="checkbox" name="jugado"> Partido Jugado
        </label>
        
        <button type="submit">Crear Partido</button>
    </form>
    
    <script>
    function cargarEquipos(id_torneo) {
        if (id_torneo === '') return;
        
        fetch(`/sistema-torneos/partidos/get_equipos.php?id=${id_torneo}`)
            .then(r => r.json())
            .then(equipos => {
                let html = '<option value="">Seleccionar</option>';
                equipos.forEach(e => {
                    html += `<option value="${e.id}">${e.nombre}</option>`;
                });
                document.getElementById('local').innerHTML = html;
                document.getElementById('visitante').innerHTML = html;
            });
    }
    </script>
</body>
</html>