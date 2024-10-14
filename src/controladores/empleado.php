<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'empleado') {
    header('Location: ../views/inicio_sesion.html');
    exit();
}

require '../config/conexion.php';

$db = conectarMongoDB();
$usuarios = $db->usuarios->find();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - Empleado</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Usuarios Registrados</h1>
    <ul>
        <?php foreach ($usuarios as $usuario): ?>
            <li><?php echo $usuario['nombre'] . ' - ' . $usuario['email']; ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="../controladores/cerrar sesion.php">Cerrar Sesión</a>
</body>
</html>
