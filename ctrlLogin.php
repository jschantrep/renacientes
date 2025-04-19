<?php
include("entorno.php");
include("modeloLogin.php");

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$usuario = validarLogin($conexion, $email, $password);

if ($usuario) {
    session_start();
    $_SESSION['usuario'] = $usuario['Nombre'];
    $_SESSION['id_usuario'] = $usuario['idDatos_Basicos'];

    header("Location: historia.php");
} else {
    echo "Correo o contraseña incorrectos.";
}

if ($usuario) {
    session_start();
    $_SESSION['usuario'] = $usuario['Nombre'];
    $_SESSION['id_usuario'] = $usuario['idDatos_Basicos'];
    $_SESSION['rol'] = $usuario['rol'];

    if ($usuario['rol'] === 'admin') {
        header("Location: vHistorias.php"); // Página del admin
    } else {
        header("Location: historia.php"); // Página de usuario normal
    }
    exit();
} else {
    echo "Correo o contraseña incorrectos.";
}
?>
