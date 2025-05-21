<?php
session_start();
include_once("entorno.php");

if (!isset($_SESSION['id_usuario'])) {
    die("Debes iniciar sesión para calificar el servicio.");
}

$id_usuario = $_SESSION['id_usuario'];
$rol = $_SESSION['rol'] ?? 'usuario';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encuesta de Calidad del Servicio - Derechos Renacientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <a href="vHistorias.php" class="btn btn-secondary mb-3">Volver</a>
    <?php if ($rol === 'admin'): ?>
        <h2>Lista de Calificaciones Recibidas</h2>
        <table class="table table-bordered table-hover mt-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Puntuación</th>
                    <th>Comentarios</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "
                    SELECT c.id, u.Nombre, c.puntuacion, c.comentarios, c.fecha
                    FROM calificaciones c
                    INNER JOIN datos_basicos u ON c.idDatos_Basicos = u.idDatos_Basicos
                    ORDER BY c.fecha DESC
                ";
                $resultado = mysqli_query($conexion, $query);

                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                        <td>{$fila['id']}</td>
                        <td>" . htmlspecialchars($fila['Nombre']) . "</td>
                        <td>{$fila['puntuacion']}</td>
                        <td>" . htmlspecialchars($fila['comentarios']) . "</td>
                        <td>{$fila['fecha']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

    <?php else: ?>
        <h2>Encuesta de Calidad del Servicio</h2>
        <p>Tu opinión es muy importante para mejorar la atención y apoyo a víctimas.</p>
        <div id="mensaje" class="alert d-none" role="alert"></div>
        <form id="formCalificacion">
            <div class="mb-3">
                <label class="form-label">¿Recibiste información clara sobre tus derechos y recursos disponibles?</label>
                <select name="informacion_clara" class="form-select" required>
                    <option value="" disabled selected>Selecciona una opción</option>
                    <option value="Sí">Sí</option>
                    <option value="Parcialmente">Parcialmente</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">¿El tiempo de respuesta a tu caso fue adecuado?</label>
                <select name="tiempo_respuesta" class="form-select" required>
                    <option value="" disabled selected>Selecciona una opción</option>
                    <option value="Sí">Sí</option>
                    <option value="Parcialmente">Parcialmente</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">¿Sientes que tu situación fue tomada en serio?</label>
                <select name="tomado_en_serio" class="form-select" required>
                    <option value="" disabled selected>Selecciona una opción</option>
                    <option value="Sí">Sí</option>
                    <option value="Parcialmente">Parcialmente</option>
                    <option value="No">No</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="puntuacion" class="form-label">Califica globalmente la atención recibida (1 a 5):</label>
                <select name="puntuacion" id="puntuacion" class="form-select" required>
                    <option value="" disabled selected>Selecciona una puntuación</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="comentarios" class="form-label">Comentarios adicionales (opcional):</label>
                <textarea name="comentarios" id="comentarios" rows="4" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Encuesta</button>
        </form>
    <?php endif; ?>
</div>
<?php if ($rol !== 'admin'): ?>
<script>
document.getElementById('formCalificacion').addEventListener('submit', function(e){
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch('ctrlCalificacion.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(mensaje => {
        const mensajeDiv = document.getElementById('mensaje');
        mensajeDiv.textContent = mensaje;
        mensajeDiv.classList.remove('d-none', 'alert-danger');
        mensajeDiv.classList.add('alert-success');

        if (mensaje.toLowerCase().includes('gracias')) {
            form.reset();
        }

        setTimeout(() => {
            mensajeDiv.classList.add('d-none');
        }, 4000);
    })
    .catch(() => {
        const mensajeDiv = document.getElementById('mensaje');
        mensajeDiv.textContent = "Error al enviar la encuesta. Intenta de nuevo.";
        mensajeDiv.classList.remove('d-none', 'alert-success');
        mensajeDiv.classList.add('alert-danger');

        setTimeout(() => {
            mensajeDiv.classList.add('d-none');
        }, 4000);
    });
});
</script>
<?php endif; ?>

</body>
</html>
