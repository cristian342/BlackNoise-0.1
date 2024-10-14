<?php
session_start();
require '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit();
    }

    $db = conectarMongoDB();
    $usuarios = $db->usuarios;

    // Verificar si el correo ya está registrado
    $usuario_existente = $usuarios->findOne(['email' => $email]);
    if ($usuario_existente) {
        echo "El correo ya está registrado.";
        exit();
    }

    // Asignación de roles
    if (strpos($email, '@blackmanager.com') !== false) {
        $rol = 'empleado';
    } elseif (strpos($email, '@blacknoise.com') !== false) {
        $rol = 'administrador';
    } else {
        $rol = 'cliente';
    }

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    $resultado = $usuarios->insertOne([
        'nombre' => $nombre,
        'email' => $email,
        'password' => $hashed_password,
        'rol' => $rol,
        'fecha_creacion' => new MongoDB\BSON\UTCDateTime()
    ]);

    // Iniciar sesión automáticamente
    $_SESSION['usuario'] = [
        'nombre' => $nombre,
        'email' => $email,
        'rol' => $rol
    ];

    // Redirigir a la página correcta según el rol
if ($rol == 'cliente') {
    header('Location: ../controladores/welcome.php'); // Ruta ajustada para cliente
} else if ($rol == 'empleado') {
    header('Location: ../controladores/empleado.php'); // Ruta ajustada para empleado
} else if ($rol == 'administrador') {
    header('Location: ../controladores/administrador.php'); // Ruta ajustada para administrador
}
exit();

}
?>
