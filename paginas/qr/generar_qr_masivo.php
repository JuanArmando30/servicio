<?php
// Evitar que cualquier warning/notice rompa el JSON
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

require_once __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . "/conexion.php";
include "../../phpqrcode/qrlib.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

// ── Validaciones básicas ──────────────────────────────────────────
if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(["status" => "error", "mensaje" => "No se recibió el archivo."]);
    exit;
}

$extension = strtolower(pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION));
if (!in_array($extension, ['xlsx', 'xls'])) {
    echo json_encode(["status" => "error", "mensaje" => "El archivo debe ser .xlsx o .xls"]);
    exit;
}

// ── Leer el Excel ─────────────────────────────────────────────────
try {
    $spreadsheet = IOFactory::load($_FILES['archivo']['tmp_name']);
    $hoja        = $spreadsheet->getActiveSheet();
    $filas       = $hoja->toArray();
} catch (Exception $e) {
    echo json_encode(["status" => "error", "mensaje" => "No se pudo leer el archivo Excel."]);
    exit;
}

// ── Detectar si la primera fila es encabezado ─────────────────────
// Si la celda A1 no es numérica, asumimos que es encabezado y la saltamos
$inicio = 0;
if (!empty($filas[0][0]) && !is_numeric($filas[0][0])) {
    $inicio = 1; // saltar encabezado (Nombre, Grado, Grupo)
}

// ── Crear carpeta de QRs si no existe ────────────────────────────
$dir = "../../assets/qrs/";
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

// ── Procesar cada fila ────────────────────────────────────────────
$generados = 0;
$errores   = 0;

for ($i = $inicio; $i < count($filas); $i++) {
    $fila = $filas[$i];

    // Ignorar filas vacías
    if (empty(trim($fila[0] ?? ''))) continue;

    $nombre = trim($fila[0] ?? '');
    $grado  = trim($fila[1] ?? '');
    $grupo  = trim($fila[2] ?? '');

    // 1. Insertar alumno en BD
    $sql = "INSERT INTO alumnos (nombre, grado, grupo) VALUES ('$nombre', '$grado', '$grupo')";

    if (!mysqli_query($conn, $sql)) {
        $errores++;
        continue;
    }

    // 2. Obtener ID del alumno insertado
    $id = mysqli_insert_id($conn);

    // 3. Generar código único
    $caracteres = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $codigo = '';
    for ($j = 0; $j < 10; $j++) {
        $codigo .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }

    // 4. Generar imagen QR
    $archivo = $dir . $codigo . ".png";
    QRcode::png($codigo, $archivo);

    // 5. Guardar código en BD
    mysqli_query($conn, "UPDATE alumnos SET codigo_qr='$codigo' WHERE id=$id");

    $generados++;
}

// ── Respuesta final ───────────────────────────────────────────────
echo json_encode([
    "status"    => "ok",
    "generados" => $generados,
    "errores"   => $errores
]);
