<?php
$host = "localhost";
$user = "root";
$pass = "Shuhua30.";
$db   = "servicio";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>