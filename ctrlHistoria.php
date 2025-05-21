<?php
session_start();

$id_usuario = $_SESSION['id_usuario'];
$rol = $_SESSION['rol'] ?? '';

include_once("entorno.php");
if ($rol === 'admin' && isset($_POST['idHistorias']) && isset($_POST['estado'])) {
    $idHistorias = mysqli_real_escape_string($conexion, $_POST['idHistorias']);
    $estado = mysqli_real_escape_string($conexion, $_POST['estado']);

    $update_query = "UPDATE historias SET estado = '$estado' WHERE idHistorias = '$idHistorias'";

    if (mysqli_query($conexion, $update_query)) {
        echo "Estado del incidente actualizado exitosamente.";
    } else {
        echo "Error al actualizar el estado: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
    exit;
}

$fecha = $_POST['fecha'] ?? '';
$tipo_incidente = $_POST['tipo_incidente'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$ubicacion = $_POST['ubicacion'] ?? '';
$testigos  = $_POST['testigos'] ?? '';

if ($fecha && $tipo_incidente && $descripcion && $ubicacion) {
    $fecha = mysqli_real_escape_string($conexion, $fecha);
    $tipo_incidente = mysqli_real_escape_string($conexion, $tipo_incidente);
    $descripcion = mysqli_real_escape_string($conexion, $descripcion);
    $ubicacion = mysqli_real_escape_string($conexion, $ubicacion);
    $testigos = mysqli_real_escape_string($conexion, $testigos);

    $query = "INSERT INTO historias (IdDatos_Basicos, fecha, tipo_incidente, descripcion, ubicacion, testigos)
    VALUES ('$id_usuario', '$fecha', '$tipo_incidente', '$descripcion', '$ubicacion', '$testigos')";

    if (mysqli_query($conexion, $query)) {
        echo "Incidente registrado exitosamente.";
    } else {
        echo "Error al registrar el incidente: " . mysqli_error($conexion);
    }
} else {
    echo "Todos los campos son obligatorios.";
}

mysqli_close($conexion);
?>
