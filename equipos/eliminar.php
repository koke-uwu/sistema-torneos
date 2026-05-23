<?php
include '../includes/conexion.php';
/** @var mysqli $conn */

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

// Validar que exista el ID en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Ejecutar la eliminación
    $sql = "DELETE FROM equipo WHERE id = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        // Redirigir a la lista
        header('Location: listar.php');
        exit;
    } else {
        echo "Error al eliminar el equipo: " . mysqli_error($conn);
    }
} else {
    // Si no hay ID, regresar a la lista
    header('Location: listar.php');
    exit;
}
?>