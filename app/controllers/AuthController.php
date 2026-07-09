<?php
require_once '../models/Usuario.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

session_start();

$modelo  = new Usuario();
$accion  = $_POST['accion'] ?? '';

switch ($accion) {

    case 'login':
        $correo   = $_POST['correo']   ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($correo) || empty($password)) {
            echo json_encode(['exito' => false, 'mensaje' => 'Completa todos los campos']);
            exit;
        }

        $usuario = $modelo->verificarLogin($correo, $password);

        if ($usuario) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre']     = $usuario['nombre'];
            echo json_encode(['exito' => true, 'nombre' => $usuario['nombre']]);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'Correo o contraseña incorrectos']);
        }
        break;

    case 'registro':
        $nombre   = $_POST['nombre']   ?? '';
        $correo   = $_POST['correo']   ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($nombre) || empty($correo) || empty($password)) {
            echo json_encode(['exito' => false, 'mensaje' => 'Completa todos los campos']);
            exit;
        }

        try {
            $id = $modelo->registrar($nombre, $correo, $password);
            echo json_encode(['exito' => true, 'id' => $id]);
        } catch (Exception $e) {
            echo json_encode(['exito' => false, 'mensaje' => 'El correo ya está registrado']);
        }
        break;

    default:
        echo json_encode(['exito' => false, 'mensaje' => 'Acción no válida']);
}
?>