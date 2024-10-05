<?php
    include 'docs/header.php';  // Incluye el encabezado
?>

<div class="container my-5">
    <h1>Pago de Impuestos</h1>
    <p>El pago de impuestos municipales puede realizarse en línea o en persona. Este trámite es necesario para cumplir con las obligaciones tributarias en La Paz.</p>

    <h3>Requisitos:</h3>
    <ul>
        <li>Cédula de identidad del contribuyente.</li>
        <li>Último aviso de pago o número de cuenta tributaria.</li>
        <li>Métodos de pago disponibles: tarjeta de crédito, débito o transferencia bancaria.</li>
    </ul>


<div class="container mt-5">
    <h2 class="text-center mb-4">Buscar Datos por Cédula</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Formulario para ingresar la cédula -->
            <form action="" method="POST">
                <div class="form-group mb-3">
                    <label for="cedula">Ingrese su Cédula</label>
                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cédula" required>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conexión a la base de datos MySQL
        $host = "localhost";  // Cambiar si es necesario
        $dbname = "bd_gamlp1";  // Nombre de tu base de datos
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

        // Consulta SQL con JOIN para obtener los datos de la persona y sus propiedades
        $sql = "
        SELECT personas.nombre, personas.cedula, propiedades.direccion_propiedad, propiedades.tipo
        FROM personas
        JOIN propiedades ON personas.id = propiedades.persona_id
        WHERE personas.cedula = ?
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $cedula);  // Enlazar el parámetro cédula
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Mostrar los datos en un formulario
            while($row = $result->fetch_assoc()) {
                echo '
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6">
                        <h3 class="text-center mb-4">Datos Encontrados</h3>
                        <form>
                            <div class="form-group mb-3">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" value="' . $row['nombre'] . '" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="cedula">Cédula</label>
                                <input type="text" class="form-control" id="cedula" value="' . $row['cedula'] . '" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="direccion_propiedad">Propiedad</label>
                                <input type="text" class="form-control" id="direccion_propiedad" value="' . $row['direccion_propiedad'] . '" readonly>
                            </div>
                        </form>
                    </div>
                </div>';
            }
        } else {
            echo '
            <div class="row justify-content-center mt-5">
                <div class="col-md-6 text-center">
                    <div class="alert alert-danger" role="alert">
                        No se encontraron datos para la cédula ingresada.
                    </div>
                </div>
            </div>';
        }

        // Cerrar la conexión
        $conn->close();
    }
    ?>

</div>

    <a href="index.php" class="btn btn-secondary">Volver a inicio</a>
</div>

<?php
    include 'docs/footer.php';  // Incluye el pie de página
?>