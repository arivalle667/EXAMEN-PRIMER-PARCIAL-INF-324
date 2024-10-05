<?php
// procesar_login.php
$email = $_POST['email'];
$password = $_POST['password'];

// Aquí puedes agregar la lógica para validar el email y la contraseña con los datos de tu base de datos
if ($email == "admin@gmail.com" && $password == "123456") {
    header("Location: lista_personas.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
