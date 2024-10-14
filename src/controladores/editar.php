<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'administrador') {
    header('Location: ../views/inicio_sesion.html');
    exit();
}

$db = conectarMongoDB();
$usuarios = $db->usuarios;

// Obtener el ID del usuario que se quiere editar
$id = new MongoDB\BSON\ObjectId($_GET['id']);

// Obtener la información del usuario
$usuario = $usuarios->findOne(['_id' => $id]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    
    // Actualizar los datos del usuario
    $usuarios->updateOne(
        ['_id' => $id],
        ['$set' => [
            'nombre' => $nombre,
            'email' => $email
        ]]
    );
    
    header('Location: administrador.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Editar Usuario</h1>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required><br>

        <label for="email">Correo:</label>
        <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>" required><br>

        <input type="submit" value="Actualizar Usuario">
    </form>
    <a href="administrador.php">Volver</a>
</body>
</html>
