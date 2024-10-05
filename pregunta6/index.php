<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Personas por Tipo de Impuesto</title>
    <!-- Bootstrap CSS para darle estilo a la tabla -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Lista de Personas por Tipo de Impuesto</h2>
    
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
    
    // Consulta SQL para obtener los datos de las personas y propiedades agrupadas por tipo de impuesto
    $sql = "
    SELECT 
        p.nombre AS Persona,
        GROUP_CONCAT(CASE WHEN pr.tipo = 'Alto' THEN pr.direccion_propiedad ELSE NULL END) AS 'Propiedades con Impuesto Alto',
        GROUP_CONCAT(CASE WHEN pr.tipo = 'Medio' THEN pr.direccion_propiedad ELSE NULL END) AS 'Propiedades con Impuesto Medio',
        GROUP_CONCAT(CASE WHEN pr.tipo = 'Bajo' THEN pr.direccion_propiedad ELSE NULL END) AS 'Propiedades con Impuesto Bajo'
    FROM 
        personas p
    JOIN 
        propiedades pr ON p.id = pr.persona_id
    GROUP BY 
        p.nombre;
    ";
    
    // Ejecutar la consulta
    $result = $conn->query($sql);
    
    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Crear la tabla con Bootstrap
        echo '<table class="table table-bordered">';
        echo '<thead class="thead-light"><tr><th>Persona</th><th>Propiedades con Impuesto Alto</th><th>Propiedades con Impuesto Medio</th><th>Propiedades con Impuesto Bajo</th></tr></thead>';
        echo '<tbody>';
        
        // Mostrar cada fila de resultados
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row["Persona"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["Propiedades con Impuesto Alto"] ?: 'N/A') . '</td>';
            echo '<td>' . htmlspecialchars($row["Propiedades con Impuesto Medio"] ?: 'N/A') . '</td>';
            echo '<td>' . htmlspecialchars($row["Propiedades con Impuesto Bajo"] ?: 'N/A') . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo "<p class='text-center'>No se encontraron resultados.</p>";
    }
    
    // Cerrar la conexión
    $conn->close();
    ?>
</div>

<!-- Bootstrap JS para interactividad -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
