<?php
class ConexionBD {

    public function getConexion() {
        $host     = 'localhost';
        $bd       = 'gfi_db';
        $usuario  = 'root';
        $password = '';

        try {
            $conexion = new PDO("mysql:host=$host;dbname=$bd;charset=utf8", $usuario, $password);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            die(json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]));
        }
    }
}
?>