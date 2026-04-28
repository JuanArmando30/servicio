<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

include "../conexion.php";

// 1. Total de QR generados (alumnos con código asignado)
$resTotal = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM alumnos 
    WHERE codigo_qr IS NOT NULL AND codigo_qr != ''
");
$total = mysqli_fetch_assoc($resTotal)['total'];

// 2. Generados hoy
$resHoy = mysqli_query($conn, "
    SELECT COUNT(*) AS hoy 
    FROM alumnos 
    WHERE DATE(fecha_registro) = CURDATE()
    AND codigo_qr IS NOT NULL AND codigo_qr != ''
");
$hoy = mysqli_fetch_assoc($resHoy)['hoy'];

// 3. Última generación (fecha del último registro con QR)
$resUltimo = mysqli_query($conn, "
    SELECT fecha_registro 
    FROM alumnos 
    WHERE codigo_qr IS NOT NULL AND codigo_qr != ''
    ORDER BY fecha_registro DESC 
    LIMIT 1
");

$ultimoTexto = "Sin registros";
if ($row = mysqli_fetch_assoc($resUltimo)) {
    $fechaUltimo = new DateTime($row['fecha_registro']);
    $ahora       = new DateTime();
    $diff        = $ahora->diff($fechaUltimo);

    if ($diff->days > 0) {
        $ultimoTexto = "Hace " . $diff->days . " día(s)";
    } elseif ($diff->h > 0) {
        $ultimoTexto = "Hace " . $diff->h . " hora(s)";
    } elseif ($diff->i > 0) {
        $ultimoTexto = "Hace " . $diff->i . " minuto(s)";
    } else {
        $ultimoTexto = "Justo ahora";
    }
}

echo json_encode([
    "status" => "ok",
    "total"  => $total,
    "hoy"    => $hoy,
    "ultimo" => $ultimoTexto
]);