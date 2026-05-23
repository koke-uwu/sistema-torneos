<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'includes/conexion.php';
    
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    
    $resultado = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario='$usuario' AND password='$password'");
    $fila = mysqli_fetch_assoc($resultado);
    
    if ($fila) {
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['rol'] = $fila['rol'];
        header("Location: admin/dashboard.php");
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistema de Torneos</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    
    <?php if(isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>
        
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Entrar</button>
    </form>
</body>
</html>