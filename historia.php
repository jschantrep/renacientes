<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario de Incidente - Derechos Renacientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .form-container {
            max-width: 600px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .top-bar {
            display: flex;
            justify-content: flex-end;
            padding: 20px;
            margin-bottom: -60px;
        }

        .top-bar a {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <div class="container top-bar">
        <a href="vHistorias.php" class="btn btn-secondary">Ver Incidentes</a>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
    <div class="container">
        <div class="form-container">
            <h2 class="mb-4 text-center">Formulario de Quejas y/o Radicados</h2>
            <div id="mensaje" class="alert alert-info" style="display: none;"></div>

            <form action="ctrlHistoria.php" method="POST">

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha del Incidente</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>
                <div class="mb-3">
                    <label for="tipo_incidente" class="form-label">Tipo de Incidente</label>
                    <select class="form-select" id="tipo_incidente" name="tipo_incidente" required>
                        <option value="agresión">Agresión</option>
                        <option value="robo">Robo</option>
                        <option value="desplazamiento">Desplazamiento Forzado</option>
                        <option value="amenaza">Amenaza</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción del Incidente</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4"
                        placeholder="Describe el incidente..." required></textarea>
                </div>
                <div class="mb-3">
                    <label for="ubicacion" class="form-label">Ubicación del Incidente</label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                </div>
                <div class="mb-3">
                    <label for="testigos" class="form-label">¿Hubo testigos?</label>
                    <textarea class="form-control" id="testigos" name="testigos" rows="2"
                        placeholder="Si hubo testigos, indícalos..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Enviar Incidente</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector("form").addEventListener("submit", function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch("ctrlHistoria.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.text())
                .then(data => {
                    const mensaje = document.getElementById("mensaje");
                    mensaje.innerText = data;
                    mensaje.style.display = "block";

                    if (data.includes("exitosamente")) {
                        form.reset();
                    }
                })
                .catch(error => {
                    console.error("Error al enviar:", error);
                });
        });
    </script>

</body>

</html>