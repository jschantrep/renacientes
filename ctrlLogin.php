<?php
include("entorno.php");
include("modeloLogin.php");

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$password = md5($password);

$usuario = validarLogin($conexion, $email, $password);

if ($usuario) {
    session_start();
    $_SESSION['usuario'] = $usuario['Nombre'];
    $_SESSION['id_usuario'] = $usuario['idDatos_Basicos'];
    $_SESSION['rol'] = $usuario['rol'];

    if ($usuario['rol'] === 'admin') {
        header("Location: vHistorias.php");
    } else {
        header("Location: historia.php");
    }
    exit();
} else {
    echo "Correo o contraseña incorrectos.";
}
?>
