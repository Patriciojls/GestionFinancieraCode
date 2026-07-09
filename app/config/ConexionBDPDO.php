<?php
class ConexionBD {
    private static $instancia = null;
    private $conexion;

    private $host     = 'localhost';
    private $bd       = 'gfi_db';
    private $usuario  = 'root';
    private $password = '';

    private function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->bd};charset=utf8",
                $this->usuario,
                $this->password
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]));
        }
    }

    public static function getInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new ConexionBD();
        }
        return self::$instancia;
    }

    public function getConexion() {
        return $this->conexion;
    }
}?>