<?php
include "conexion.php";
include "../phpqrcode/qrlib.php";

// Validar datos
if (!isset($_POST['nombre'])) {
    echo json_encode(["status" => "error"]);
    exit;
}

$nombre = $_POST['nombre'];
$grado  = $_POST['grado'];
$grupo  = $_POST['grupo'];

// 1. Insertar alumno
$sql = "INSERT INTO alumnos (nombre, grado, grupo) 
        VALUES ('$nombre', '$grado', '$grupo')";

if (!mysqli_query($conn, $sql)) {
    echo json_encode(["status" => "error"]);
    exit;
}

// 2. Obtener ID
$id = mysqli_insert_id($conn);

// 3. Generar código único (más seguro)
$codigo = bin2hex(random_bytes(8));

// 4. Crear carpeta si no existe
$dir = "../assets/qrs/";
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

// 5. Ruta del QR
$archivo = $dir . $codigo . ".png";

// 6. Generar QR
QRcode::png($codigo, $archivo);

// 7. Guardar código en BD
mysqli_query($conn, "UPDATE alumnos SET codigo_qr='$codigo' WHERE id=$id");

// 8. Respuesta
echo json_encode([
    "status" => "ok",
    "qr" => $archivo
]);