<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
include __DIR__ . "/../qr/conexion.php";

$codigo = trim($_GET['codigo'] ?? '');

if ($codigo === '') {
    echo json_encode(["status" => "error", "mensaje" => "Código vacío."]);
    exit;
}

// Buscar alumno por código QR
$codigo = mysqli_real_escape_string($conn, $codigo);
$res = mysqli_query($conn, "SELECT * FROM alumnos WHERE codigo_qr = '$codigo' LIMIT 1");

if (!$res || mysqli_num_rows($res) === 0) {
    echo json_encode(["status" => "error", "mensaje" => "Alumno no encontrado."]);
    exit;
}

$alumno = mysqli_fetch_assoc($res);
$id     = $alumno['id'];

// Lunes de la semana actual como fecha ancla
$lunes = date('Y-m-d', strtotime('monday this week'));

// Buscar pago existente de esta semana
$resPago = mysqli_query($conn, "SELECT * FROM pagos WHERE alumno_id = $id AND semana = '$lunes' LIMIT 1");
$pago    = $resPago ? mysqli_fetch_assoc($resPago) : null;

echo json_encode([
    "status"  => "ok",
    "alumno"  => $alumno,
    "semana"  => $lunes,
    "pago"    => $pago   // null si no hay pago esta semana aún
]);