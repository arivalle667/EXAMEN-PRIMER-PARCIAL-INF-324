<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM personas WHERE id = $id";
    mysqli_query($conn, $query);
}

header('Location: lista_personas.php');
?>
