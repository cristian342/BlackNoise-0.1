<?php
session_start();
require '../config/conexion.php'; // Ajuste en la ruta

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'administrador') {
    header('Location: ../views/inicio_sesion.html'); // Ajuste en la ruta
    exit();
}

$db = conectarMongoDB();
$usuarios = $db->usuarios->find();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - Administrador</title>
    <link rel="stylesheet" href="../../public/css/styles.css"> <!-- Ajuste en la ruta -->
</head>
<body>
    <h1>Administrar Usuarios</h1>
    <ul>
        <?php foreach ($usuarios as $usuario): ?>
            <li>
                <?php echo $usuario['nombre'] . ' - ' . $usuario['email']; ?>
                <a href="editar.php?id=<?php echo $usuario['_id']; ?>">Editar</a>
                <a href="eliminar.php?id=<?php echo $usuario['_id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="../controladores/cerrar sesion.php">Cerrar Sesión</a> <!-- Ajuste en la ruta -->
</body>
</html>


