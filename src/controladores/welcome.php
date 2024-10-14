<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'cliente') {
    header('Location: ../views/inicio_sesion.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['usuario']['nombre']; ?>!</h1>
    <a href="../controladores/cerrar sesion.php">Cerrar Sesión</a>
</body>
</html>
