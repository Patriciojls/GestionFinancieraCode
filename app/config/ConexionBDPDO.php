<?php
class ConexionBD {
    private static $instancia = null;
    private $conexion;

    private $host     = 'localhost';
    private $bd       = 'gfi_db';
    private $usuario  = 'root';      // tu usuario MySQL
    private $password = '';          // tu contraseña MySQL

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
}


/*require_once __DIR__ . "/../configs/ConexionBD.php";

class ConexionBDPDO extends ConexionDB{
    private $conexionPDO;

    public function conectarBD(){
        try{
            $this->conexionPDO = new PDO(
                "mysql:host=".$this->hostBD.";dbname=".$this->nombreBD,
                $this->usuarioBD,
                $this->passwordBD
            );
            $this->conexionPDO->setAttribute(
                PDO::ATTR_ERRMODE, 
                PDO::ERRMODE_EXCEPTION
                );

            return $this->conexionPDO;

        }catch(PDOException $e){
          die("Error al conectar a la base de datos con PDO: " . $e->getMessage());
        }
    }
    public function cerrarBD(){
        if($this->conexionPDO){
            $this->conexionPDO = null;
        }
    }
}
*/


?>