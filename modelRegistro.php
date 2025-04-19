<?php
function registrarUsuario($conexion, $nombre, $documento, $direccion, $email, $tel, $password) {
    $stmt = $conexion->prepare("INSERT INTO datos_basicos (Nombre, Documento, Direccion, email, tel, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $documento, $direccion, $email, $tel, $password);
    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error en la consulta: " . $stmt->error;
        return false;
    }
}
?>
