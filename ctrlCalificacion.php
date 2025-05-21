<?php
session_start();
include_once("entorno.php");

if (!isset($_SESSION['id_usuario'])) {
    http_response_code(403);
    echo "Debes iniciar sesión para enviar la encuesta.";
    exit;
}

$idDatos_Basicos = $_SESSION['id_usuario'];

$camposRequeridos = ['informacion_clara', 'tiempo_respuesta', 'tomado_en_serio', 'puntuacion'];

foreach ($camposRequeridos as $campo) {
    if (empty($_POST[$campo])) {
        http_response_code(400);
        echo "El campo '$campo' es obligatorio.";
        exit;
    }
}

$informacion_clara = mysqli_real_escape_string($conexion, $_POST['informacion_clara']);
$tiempo_respuesta = mysqli_real_escape_string($conexion, $_POST['tiempo_respuesta']);
$tomado_en_serio = mysqli_real_escape_string($conexion, $_POST['tomado_en_serio']);
$puntuacion = (int)$_POST['puntuacion'];
$comentarios = isset($_POST['comentarios']) ? mysqli_real_escape_string($conexion, $_POST['comentarios']) : '';

if ($puntuacion < 1 || $puntuacion > 5) {
    http_response_code(400);
    echo "La puntuación debe estar entre 1 y 5.";
    exit;
}

$query = "INSERT INTO calificaciones 
    (idDatos_Basicos, informacion_clara, tiempo_respuesta, tomado_en_serio, puntuacion, comentarios) 
    VALUES 
    ('$idDatos_Basicos', '$informacion_clara', '$tiempo_respuesta', '$tomado_en_serio', $puntuacion, '$comentarios')";

if (mysqli_query($conexion, $query)) {
    echo "Gracias por enviarnos tu opinión.";
} else {
    http_response_code(500);
    echo "Error al guardar la encuesta: " . mysqli_error($conexion);
}

mysqli_close($conexion);
