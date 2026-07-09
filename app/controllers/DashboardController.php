<?php
require_once '../models/Ingreso.php';
require_once '../models/Gasto.php';
require_once '../models/Deuda.php';
require_once '../models/Meta.php';

header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['exito' => false, 'mensaje' => 'Sesión no iniciada']);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

try {
    $modeloIngreso = new Ingreso();
    $modeloGasto   = new Gasto();
    $modeloDeuda   = new Deuda();
    $modeloMeta    = new Meta();

    // Ajusta estos nombres de método según cómo estén definidos en tus modelos
    $ingresos = $modeloIngreso->obtenerPorUsuario($id_usuario);
    $gastos   = $modeloGasto->obtenerPorUsuario($id_usuario);
    $deudas   = $modeloDeuda->obtenerPorUsuario($id_usuario);
    $metas    = $modeloMeta->obtenerPorUsuario($id_usuario);

    $totalIngresos = array_sum(array_column($ingresos, 'monto'));
    $totalGastos   = array_sum(array_column($gastos, 'monto'));
    $totalDeudas   = array_sum(array_column($deudas, 'monto'));
    $totalMetas    = count($metas);

    echo json_encode([
        'exito' => true,
        'totalIngresos' => $totalIngresos,
        'totalGastos'   => $totalGastos,
        'totalDeudas'   => $totalDeudas,
        'totalMetas'    => $totalMetas
    ]);

} catch (Exception $e) {
    echo json_encode(['exito' => false, 'mensaje' => 'Error al cargar el resumen']);
}