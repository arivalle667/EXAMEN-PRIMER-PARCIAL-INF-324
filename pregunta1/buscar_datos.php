<?php
// Conexión a la base de datos MySQL
$host = "localhost";  // Cambiar si es necesario
$dbname = "bd_gamlp";  // Nombre de tu base de datos
$username = "root";  // Usuario de la base de datos
$password = "";  // Contraseña de la base de datos

// Crear una conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la cédula enviada por el formulario
$cedula = $_POST['cedula'];

// Consulta SQL para buscar los datos por cédula
$sql = "SELECT * FROM personas WHERE cedula = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cedula);  // Enlazar el parámetro cédula
$stmt->execute();
$result = $stmt->get_result();

// Mostrar los resultados
if ($result->num_rows > 0) {
    // Mostrar los datos de la persona
    while($row = $result->fetch_assoc()) {
        echo "<h3>Datos Encontrados:</h3>";
        echo "<p><strong>Nombre:</strong> " . $row['nombre'] . "</p>";
        echo "<p><strong>Cédula:</strong> " . $row['cedula'] . "</p>";
        echo "<p><strong>Dirección:</strong> " . $row['direccion'] . "</p>";
    }
} else {
    echo "<p>No se encontraron datos para la cédula ingresada.</p>";
}

// Cerrar la conexión
$conn->close();
?>
