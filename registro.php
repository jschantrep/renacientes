<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro - Derechos Renacientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .form-container {
            max-width: 500px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-container">
            <h2 class="mb-4 text-center">Crear Cuenta</h2>
            <div id="mensaje" class="alert alert-info" style="display: none;"></div>
            <form action="ctrlRegistro.php" method="POST">
                <div class="mb-3">
                    <label for="Nombre" class="form-label">Nombre completo</label>
                    <input type="text" class="form-control" id="Nombre" name="Nombre" required>
                </div>
                <div class="mb-3">
                    <label for="Documento" class="form-label">Número de Identificación</label>
                    <input type="text" class="form-control" id="Documento" name="Documento" required>
                </div>
                <div class="mb-3">
                    <label for="Direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="Direccion" name="Direccion" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="tel" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="tel" name="tel" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Registrarse</button>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector("form").addEventListener("submit", function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch("ctrlRegistro.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.text())
                .then(data => {
                    const mensaje = document.getElementById("mensaje");
                    mensaje.innerHTML = data;
                    mensaje.style.display = "block";

                    if (data.includes("Registro exitoso")) {
                        mensaje.classList.remove("alert-info");
                        mensaje.classList.add("alert-success");
                        form.reset();
                    } else {
                        mensaje.classList.remove("alert-success");
                        mensaje.classList.add("alert-danger");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        });
    </script>

</body>

</html>