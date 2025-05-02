<?php
// Incluir el archivo de configuración
require_once 'config.php';

// Establecer la conexión
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}
echo "Conexión exitosa!";
?>

