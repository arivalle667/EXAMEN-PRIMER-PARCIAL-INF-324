<?php
include 'conexion.php'; // Conexión a la base de datos

// Verificar si estamos editando una persona
$persona = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM personas WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $persona = mysqli_fetch_assoc($result);
}

// Guardar o actualizar persona
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $direccion = $_POST['direccion'];
    $direccion_propiedad = $_POST['direccion_propiedad'];
    $tipo = $_POST['tipo'];

    if ($persona) {
        // Actualizar persona
        $query = "UPDATE personas SET nombre = '$nombre', cedula = '$cedula', direccion = '$direccion' WHERE id = $id";
        mysqli_query($conn, $query);

        // Actualizar propiedad
        $query_prop = "UPDATE propiedades SET direccion_propiedad = '$direccion_propiedad', tipo = '$tipo' WHERE persona_id = $id";
        mysqli_query($conn, $query_prop);
    } else {
        // Crear nueva persona
        $query = "INSERT INTO personas (nombre, cedula, direccion) VALUES ('$nombre', '$cedula', '$direccion')";
        mysqli_query($conn, $query);

        // Obtener el ID de la persona recién creada
        $persona_id = mysqli_insert_id($conn);

        // Crear nueva propiedad asociada a la persona
        $query_prop = "INSERT INTO propiedades (direccion_propiedad, tipo, persona_id) VALUES ('$direccion_propiedad', '$tipo', '$persona_id')";
        mysqli_query($conn, $query_prop);
    }

    header('Location: lista_personas.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $persona ? 'Editar Persona' : 'Registrar Persona'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2><?php echo $persona ? 'Editar Persona' : 'Registrar Persona'; ?></h2>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $persona['nombre'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="cedula" class="form-label">Cédula</label>
                <input type="text" class="form-control" name="cedula" value="<?php echo $persona['cedula'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccion" value="<?php echo $persona['direccion'] ?? ''; ?>" required>
            </div>
            <hr>
            <h3>Propiedad</h3>
            <div class="mb-3">
                <label for="direccion_propiedad" class="form-label">Dirección de la Propiedad</label>
                <input type="text" class="form-control" name="direccion_propiedad" value="<?php echo $persona ? get_propiedad($persona['id'])['direccion_propiedad'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Propiedad</label>
                <input type="text" class="form-control" name="tipo" value="<?php echo $persona ? get_propiedad($persona['id'])['tipo'] : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo $persona ? 'Actualizar' : 'Registrar'; ?></button>
        </form>
    </div>
</body>
</html>

<?php
// Función para obtener los datos de la propiedad
function get_propiedad($persona_id) {
    global $conn;
    $query = "SELECT * FROM propiedades WHERE persona_id = $persona_id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}
?>
