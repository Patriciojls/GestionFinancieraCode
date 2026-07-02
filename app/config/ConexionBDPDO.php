<?php
require_once __DIR__ . "/../configs/ConexionBD.php";

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