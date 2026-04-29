<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

include __DIR__ . "/../qr/conexion.php";

// Recoger filtros (vienen del fetch como query params)
$nombre = trim($_GET['nombre'] ?? '');
$grado  = trim($_GET['grado']  ?? '');
$grupo  = trim($_GET['grupo']  ?? '');

// Construir WHERE dinámico
$condiciones = [];

if ($nombre !== '') {
    $nombre = mysqli_real_escape_string($conn, $nombre);
    $condiciones[] = "nombre LIKE '%$nombre%'";
}
if ($grado !== '') {
    $grado = mysqli_real_escape_string($conn, $grado);
    $condiciones[] = "grado = '$grado'";
}
if ($grupo !== '') {
    $grupo = mysqli_real_escape_string($conn, $grupo);
    $condiciones[] = "grupo = '$grupo'";
}

$where = count($condiciones) > 0
    ? "WHERE " . implode(" AND ", $condiciones)
    : "";

// Consulta principal
$sql = "SELECT id, nombre, grado, grupo, codigo_qr, fecha_registro
        FROM alumnos
        $where
        ORDER BY fecha_registro DESC";

$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    echo json_encode(["status" => "error", "mensaje" => "Error en la consulta."]);
    exit;
}

$alumnos = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $alumnos[] = $fila;
}

// Obtener valores únicos de grado y grupo para los selectores del filtro
$gradosRes = mysqli_query($conn, "SELECT DISTINCT grado FROM alumnos WHERE grado != '' ORDER BY grado");
$gruposRes = mysqli_query($conn, "SELECT DISTINCT grupo FROM alumnos WHERE grupo != '' ORDER BY grupo");

$grados = [];
while ($g = mysqli_fetch_assoc($gradosRes)) $grados[] = $g['grado'];

$grupos = [];
while ($g = mysqli_fetch_assoc($gruposRes)) $grupos[] = $g['grupo'];

echo json_encode([
    "status"   => "ok",
    "total"    => count($alumnos),
    "alumnos"  => $alumnos,
    "grados"   => $grados,
    "grupos"   => $grupos
]);
