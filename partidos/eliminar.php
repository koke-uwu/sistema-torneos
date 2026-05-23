<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/conexion.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM partido WHERE id=$id");

header("Location: listar.php");
?>