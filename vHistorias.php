<?php
session_start();
include_once("entorno.php");

$id_usuario = $_SESSION['id_usuario'] ?? null;
$tipo_usuario = $_SESSION['rol'] ?? 'usuario';

if ($tipo_usuario === 'admin') {
    $query = "
        SELECT h.idHistorias, h.fecha, h.tipo_incidente, h.descripcion, h.ubicacion, h.testigos,
               u.Nombre, u.Documento, h.estado
        FROM historias h
        INNER JOIN datos_basicos u ON h.IdDatos_Basicos = u.idDatos_Basicos
        ORDER BY h.fecha DESC
    ";
} else {
    $query = "
        SELECT h.idHistorias, h.fecha, h.tipo_incidente, h.descripcion, h.ubicacion, h.testigos,
               u.Nombre, u.Documento, h.estado
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
        <br>
        <ul class="nav nav-tabs mb-4">
    <?php if ($tipo_usuario === 'admin'): ?>
        <li class="nav-item">
            <a class="nav-link" href="formCalificacion.php">Ver Calificaciones</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="reportPdf.php">Exportar a PDF</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link" href="formCalificacion.php">Calificar el Servicio</a>
        </li>
    <?php endif; ?>

    <li class="nav-item ms-auto">
        <a class="nav-link" href="historia.php">Volver</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-danger" href="logout.php">Cerrar Sesión</a>
    </li>
</ul>
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
                        <th>Estado</th>
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
                            <td class="text-center">
                                <?php if ($tipo_usuario === 'admin'): ?>
                                    <select class="form-select form-select-sm"
                                        onchange="actualizarEstado(<?php echo $fila['idHistorias']; ?>, this.value)">

                                        <?php
                                        $estados = ['Pendiente', 'En revisión', 'Cerrado'];
                                        foreach ($estados as $estado) {
                                            $selected = $fila['estado'] === $estado ? 'selected' : '';
                                            echo "<option value=\"$estado\" $selected>$estado</option>";
                                        }
                                        ?>
                                    </select>
                                    <div id="mensaje-<?php echo $fila['idHistorias']; ?>" class="text-success small mt-1"></div>
                                <?php else: ?>
                                    <div>
                                        <?php echo htmlspecialchars($fila['estado']); ?>
                                    </div>
                                    <?php if ($fila['estado'] === 'Cerrado'): ?>
                                        <div class="alert alert-info mt-2 p-2 mb-0 small">
                                            Tu novedad ha sido escalada. Pronto recibirás una respuesta.
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>



                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function actualizarEstado(id, nuevoEstado) {
            const formData = new FormData();
            formData.append('idHistorias', id);
            formData.append('estado', nuevoEstado);

            fetch('ctrlHistoria.php', {
                method: 'POST',
                body: formData
            })
                .then(resp => resp.text())
                .then(mensaje => {
                    const mensajeDiv = document.getElementById('mensaje-' + id);
                    mensajeDiv.innerText = mensaje;
                    mensajeDiv.classList.remove('text-danger');
                    mensajeDiv.classList.add('text-success');

                    setTimeout(() => {
                        mensajeDiv.innerText = '';
                    }, 3000);
                })
                .catch(error => {
                    const mensajeDiv = document.getElementById('mensaje-' + id);
                    mensajeDiv.innerText = "Error al enviar la solicitud.";
                    mensajeDiv.classList.remove('text-success');
                    mensajeDiv.classList.add('text-danger');

                    setTimeout(() => {
                        mensajeDiv.innerText = '';
                    }, 3000);
                });
        }
    </script>



</body>

</html>