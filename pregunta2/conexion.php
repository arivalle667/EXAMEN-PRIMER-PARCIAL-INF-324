<?php
// conexion.php
$servername = "localhost";
$username = "root"; // Por defecto en XAMPP es 'root'
$password = ""; // Por defecto en XAMPP no hay contraseña para 'root'
$dbname = "bd_gamlp1";

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
