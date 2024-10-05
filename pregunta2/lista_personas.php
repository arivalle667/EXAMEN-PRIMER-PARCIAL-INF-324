<?php
include 'conexion.php'; // Conexión a la base de datos

$query = "SELECT personas.*, propiedades.direccion_propiedad FROM personas
          LEFT JOIN propiedades ON personas.id = propiedades.persona_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Personas y Propiedades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Personas y Propiedades</h2>
        <a href="form_persona.php" class="btn btn-success mb-3">Registrar Nueva Persona</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Cédula</th>
                    <th>Dirección</th>
                    <th>Propiedad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $id=1; while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php if ($id > 0) { echo $id; $id=$id+1; } ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['cedula']; ?></td>
                        <td><?php echo $row['direccion']; ?></td>
                        <td><?php echo $row['direccion_propiedad']; ?></td>
                        <td>
                            <a href="form_persona.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                            <a href="eliminar_persona.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
