<?php
include 'includes/conexion.php';

$torneos = mysqli_query($conn, "SELECT * FROM torneo");
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">⚽ Sistema de Torneos</span>
            <a href="login.php" class="btn btn-primary">Admin</a>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h2>Torneos Disponibles</h2>
        <div class="row">
            <?php while($torneo = mysqli_fetch_assoc($torneos)): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $torneo['nombre'] ?></h5>
                            <a href="torneo.php?id=<?= $torneo['id'] ?>" class="btn btn-success">Ver</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>