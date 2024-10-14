<?php
// Conectar con MongoDB
require __DIR__ . '/../../vendor/autoload.php'; // Ruta ajustada

use MongoDB\Client;

function conectarMongoDB() {
    $client = new Client("mongodb://localhost:27017");
    return $client->BlackNoiseDB; // Nombre de la base de datos
}
?>
