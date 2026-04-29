<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');
include __DIR__ . "/../qr/conexion.php";

$datos = json_decode(file_get_contents("php://input"), true);

$alumno_id = intval($datos['alumno_id'] ?? 0);
$semana    = $datos['semana']    ?? '';
$lunes     = intval($datos['lunes']     ?? 0);
$martes    = intval($datos['martes']    ?? 0);
$miercoles = intval($datos['miercoles'] ?? 0);
$jueves    = intval($datos['jueves']    ?? 0);
$viernes   = intval($datos['viernes']   ?? 0);

if ($alumno_id === 0 || $semana === '') {
    echo json_encode(["status" => "error", "mensaje" => "Datos incompletos."]);
    exit;
}

// ── Calcular totales ──────────────────────────────────────────────
$dias_comedor  = $lunes + $martes + $miercoles + $jueves + $viernes;
$costo_comedor = $dias_comedor * 20;
$costo_computo = max(0, 15 - ($dias_comedor * 3));
$total         = $costo_comedor + $costo_computo;

// ── INSERT o UPDATE (semana única por alumno) ─────────────────────
$sql = "INSERT INTO pagos 
            (alumno_id, semana, lunes, martes, miercoles, jueves, viernes,
             dias_comedor, costo_comedor, costo_computo, total)
        VALUES
            ($alumno_id, '$semana', $lunes, $martes, $miercoles, $jueves, $viernes,
             $dias_comedor, $costo_comedor, $costo_computo, $total)
        ON DUPLICATE KEY UPDATE
            lunes=$lunes, martes=$martes, miercoles=$miercoles,
            jueves=$jueves, viernes=$viernes,
            dias_comedor=$dias_comedor, costo_comedor=$costo_comedor,
            costo_computo=$costo_computo, total=$total";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status"        => "ok",
        "dias_comedor"  => $dias_comedor,
        "costo_comedor" => $costo_comedor,
        "costo_computo" => $costo_computo,
        "total"         => $total
    ]);
} else {
    echo json_encode(["status" => "error", "mensaje" => mysqli_error($conn)]);
}