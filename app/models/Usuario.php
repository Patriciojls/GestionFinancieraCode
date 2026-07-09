<?php
require_once '../config/ConexionBDPDO.php';

class Usuario {
    private $db;

    public function __construct() {
        $this->db = ConexionBD::getInstancia()->getConexion();
    }

    // Registrar usuario nuevo
    public function registrar($nombre, $correo, $password) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $sql  = "INSERT INTO USUARIO (nombre, correo, contraseña_hash, fecha_registro, estado)
                 VALUES (:nombre, :correo, :hash, CURDATE(), 'Activo')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':hash'   => $hash
        ]);
        return $this->db->lastInsertId();
    }

    // Buscar usuario por correo
    public function buscarPorCorreo($correo) {
        $sql  = "SELECT * FROM USUARIO WHERE correo = :correo LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':correo' => $correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verificar login
    public function verificarLogin($correo, $password) {
        $usuario = $this->buscarPorCorreo($correo);
        if ($usuario && password_verify($password, $usuario['contraseña_hash'])) {
            return $usuario;
        }
        return false;
    }
}
?>