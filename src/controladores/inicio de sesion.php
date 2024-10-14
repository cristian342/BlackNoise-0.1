<?php
session_start();
require __DIR__ . '/../config/conexion.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos de formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Conectar a la base de datos MongoDB
    $db = conectarMongoDB();
    $usuarios = $db->usuarios; // Colección de usuarios

    // Buscar el usuario por el correo electrónico
    $usuario = $usuarios->findOne(['email' => $email]);

    if ($usuario) {
        // Verificar si la contraseña es correcta
        if (password_verify($password, $usuario['password'])) {
            // Guardar datos del usuario en la sesión
            $_SESSION['usuario'] = [
                'id' => (string) $usuario['_id'],
                'nombre' => $usuario['nombre'],
                'email' => $usuario['email'],
                'rol' => $usuario['rol'] // Asignar el rol
            ];

            // Redirigir según el rol
            $rol = $usuario['rol']; // Asignar el valor del rol

            if ($rol == 'cliente') {
                header('Location: ../controladores/welcome.php'); // Redirigir al empleado
            } else if ($rol == 'empleado') {
                header('Location: ../controladores/empleado.php'); // Redirigir al empleado
            } else if ($rol == 'administrador') {
                header('Location: ../controladores/administrador.php'); // Redirigir al administrador
            }
            exit();
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado
        echo "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>
</head>
<body>
    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
