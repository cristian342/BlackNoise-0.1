<?php
session_start();
require '../config/conexion.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'administrador') {
    header('Location: ../views/inicio_sesion.html');
    exit();
}

$db = conectarMongoDB();
$usuarios = $db->usuarios;

// Obtener el ID del usuario que se quiere eliminar
$id = new MongoDB\BSON\ObjectId($_GET['id']);

// Eliminar el usuario
$usuarios->deleteOne(['_id' => $id]);

header('Location: administrador.php');
exit();
?>
