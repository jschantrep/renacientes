<?php
session_start();
include_once("entorno.php");

$id_usuario = $_SESSION['id_usuario'] ?? null;
$tipo_usuario = $_SESSION['rol'] ?? 'usuario';

if ($tipo_usuario === 'admin') {
    $query = "
        SELECT h.idHistorias, h.fecha, h.tipo_incidente, h.descripcion, h.ubicacion, h.testigos,
               u.Nombre, u.Documento
        FROM historias h
        INNER JOIN datos_basicos u ON h.IdDatos_Basicos = u.idDatos_Basicos
        ORDER BY h.fecha DESC
    ";
} else {
    $query = "
        SELECT h.idHistorias, h.fecha, h.tipo_incidente, h.descripcion, h.ubicacion, h.testigos,
               u.Nombre, u.Documento
        FROM historias h
        INNER JOIN datos_basicos u ON h.IdDatos_Basicos = u.idDatos_Basicos
        WHERE h.IdDatos_Basicos = $id_usuario
        ORDER BY h.fecha DESC
    ";
}

$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historias Registradas - Derechos Renacientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .table-container {
            margin: 60px auto;
            max-width: 95%;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container table-container">
        <h2 class="mb-4 text-center">Historias Registradas</h2>
        <div class="d-flex justify-content-between mb-3">
            <a href="reportExcel.php" class="btn btn-success">Exportar a Excel</a>
            <?php if ($tipo_usuario === 'admin'): ?>
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            <?php else: ?>
                <a href="historia.php" class="btn">Volver</a>
            <?php endif; ?>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Documento</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Ubicación</th>
                        <th>Testigos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td class="text-center"><?php echo $fila['idHistorias']; ?></td>
                            <td><?php echo htmlspecialchars($fila['Nombre']); ?></td>
                            <td><?php echo htmlspecialchars($fila['Documento']); ?></td>
                            <td><?php echo $fila['fecha']; ?></td>
                            <td><?php echo htmlspecialchars($fila['tipo_incidente']); ?></td>
                            <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($fila['ubicacion']); ?></td>
                            <td><?php echo htmlspecialchars($fila['testigos']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>