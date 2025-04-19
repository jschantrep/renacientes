<?php

include("entorno.php");
include("modelRegistro.php");

$nombre = $_POST['Nombre'] ?? '';
$documento = $_POST['Documento'] ?? '';
$direccion = $_POST['Direccion'] ?? '';
$email = $_POST['email'] ?? '';
$tel = $_POST['tel'] ?? '';
$password = $_POST['password'] ?? '';
$password_encriptado = md5($password);

if ($nombre && $documento && $direccion && $email && $tel && $password) {
    if (registrarUsuario($conexion, $nombre, $documento, $direccion, $email, $tel, $password_encriptado)) {
        echo "Registro exitoso. <a href='login.php'>Inicia sesión</a>";
    } else {
        echo "Error al registrar usuario.";
    }
} else {
    echo "Todos los campos son obligatorios.";
}
?>
