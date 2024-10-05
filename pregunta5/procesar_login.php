<?php
// Configuración de conexión a la base de datos
$host = "localhost";  // Cambia esto según tu configuración
$dbname = "bd_gamlp1";  // Nombre de tu base de datos
$username = "root";  // Usuario de la base de datos
$password = "";  // Contraseña de la base de datos

// Crear la conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$cedula = $_POST['cedula'];
$codigo_catastral = $_POST['direccion_propiedad'];

// Escapar los datos para prevenir inyecciones
$cedula = $conn->real_escape_string($cedula);
$codigo_catastral = $conn->real_escape_string($codigo_catastral);

// Verificar si existen en la base de datos
$sql = "
    SELECT p.cedula, pr.direccion_propiedad
    FROM personas p
    JOIN propiedades pr ON p.id = pr.persona_id
    WHERE p.cedula = '$cedula' AND pr.direccion_propiedad = '$codigo_catastral'
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Si el CI y la dirección de la propiedad existen, hacer la solicitud al servidor de C#
    $codigo_catastral = substr($codigo_catastral, -5); // Obtener los últimos 5 caracteres

    // URL de la API en C# (cambiar según el host y puerto de tu API)
    $url = "https://localhost:7273/api/impuestos?codigo_catastral=" . urlencode($codigo_catastral);

    // Inicializar cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Si estás usando un certificado autofirmado, desactivar la verificación SSL (solo en desarrollo)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Desactiva la verificación SSL para evitar errores en desarrollo

    // Ejecutar la solicitud
    $response = curl_exec($ch);
    
    // Verificar si hubo errores en cURL
    if ($response === false) {
        echo "Error: " . curl_error($ch);
    } else {
        // Mostrar el resultado al usuario en la misma página
        echo "<h2>Resultado del servidor: " . htmlspecialchars($response) . "</h2>";
    }

    // Cerrar cURL
    curl_close($ch);

} else {
    // Mostrar mensaje de error si el CI o la dirección no existen en la base de datos
    echo "<h3>Error: El CI o la Dirección de la Propiedad no existen en nuestra base de datos.</h3>";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
