<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de tu Impuesto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Verificar Código Catastral</h3>
                        <form action="procesar_login.php" method="POST">
                            <!-- CI -->
                            <div class="mb-3">
                                <label for="cedula" class="form-label">Cédula de Identidad (CI)</label>
                                <input type="text" class="form-control" id="cedula" name="cedula" required>
                            </div>
                            <!-- Dirección de la Propiedad -->
                            <div class="mb-3">
                                <label for="direccion_propiedad" class="form-label">Dirección de la Propiedad</label>
                                <input type="text" class="form-control" id="direccion_propiedad" name="direccion_propiedad" required>
                            </div>
                            <!-- Botón de Verificar -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Verificar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
