<?php
include '../includes/conexion.php';
/** @var mysqli $conn */

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

// 1. Validar que exista el ID en la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: listar.php');
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Obtener los datos actuales del equipo para mostrarlos en el formulario
$resultado = mysqli_query($conn, "SELECT * FROM equipo WHERE id = '$id'");
$equipo = mysqli_fetch_assoc($resultado);

// Si el ID no existe en la base de datos
if (!$equipo) {
    echo "El equipo no existe.";
    exit;
}

// 3. Procesar el formulario cuando se envía (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);

    if (!empty($nombre)) {
        $sql = "UPDATE equipo SET nombre = '$nombre' WHERE id = '$id'";
        
        if (mysqli_query($conn, $sql)) {
            header('Location: listar.php');
            exit;
        } else {
            $error = "Error al actualizar el equipo: " . mysqli_error($conn);
        }
    } else {
        $error = "El nombre no puede estar vacío.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Equipo</title>
</head>
<body>
    <h1>Editar Equipo</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="editar.php?id=<?= $equipo['id'] ?>">
        <label for="nombre">Nombre del Equipo:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $equipo['nombre'] ?>" required>
        <br><br>
        <button type="submit">Actualizar</button>
        <a href="listar.php">Cancelar</a>
    </form>
</body>
</html>