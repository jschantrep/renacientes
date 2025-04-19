<?php
function validarLogin($conexion, $email, $password) {
    $stmt = $conexion->prepare("SELECT idDatos_Basicos, Nombre, rol FROM datos_basicos WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        return $resultado->fetch_assoc();
    } else {
        return false;
    }
}
?>
