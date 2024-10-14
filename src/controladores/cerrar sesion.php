<?php
session_start();
session_unset();  // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirigir a la página de inicio de sesión (HTML) en la carpeta 'views'
header('Location: http://localhost/BlackNoise%200.1/views/inicio_sesion.html');
exit();
?>
