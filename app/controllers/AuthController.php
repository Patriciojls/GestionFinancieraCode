<?php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    private Usuario $usuarioModel;

    public function __construct()
    {
        // Iniciamos sesión si no está activa para poder mover los mensajes entre páginas
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->usuarioModel = new Usuario();
    }

    /**
     * Punto de entrada: lee "accion" del POST y despacha
     * al método correspondiente de la clase.
     */
    public function manejarPeticion(): void
    {
        $accion = $_POST['accion'] ?? '';

        match ($accion) {
            'login'    => $this->login(),
            'registro' => $this->registro(),
            'logout'   => $this->logout(),
            default    => $this->redirigir('../views/login.php', 'error', 'Acción no válida'),
        };
    }

    private function login(): void
    {
        $correo   = $_POST['correo']   ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($correo) || empty($password)) {
            $this->redirigir('../views/login.php', 'error', 'Completa todos los campos');
            return;
        }

        $usuario = $this->usuarioModel->verificarLogin($correo, $password);

        if ($usuario) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre']     = $usuario['nombre'];
            
            // Redirección directa al Dashboard al tener éxito
            header("Location: ../views/dashboard.php");
            exit;
        } else {
            $this->redirigir('../views/login.php', 'error', 'Correo o contraseña incorrectos');
        }
    }

    private function registro(): void
    {
        $nombre   = $_POST['nombre']   ?? '';
        $correo   = $_POST['correo']   ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($nombre) || empty($correo) || empty($password)) {
            $this->redirigir('../views/registro.php', 'error', 'Completa todos los campos');
            return;
        }

        try {
            $id = $this->usuarioModel->registrar($nombre, $correo, $password);
            
            // Si se registra bien, mandamos el mensaje de éxito hacia el login
            $this->redirigir('../views/login.php', 'exito', 'Cuenta creada correctamente. ¡Inicia sesión!');
        } catch (Exception $e) {
            $this->redirigir('../views/registro.php', 'error', 'El correo ya está registrado');
        }
    }

    private function logout(): void
    {
        session_destroy();
        header("Location: ../views/login.php");
        exit;
    }

    /**
     * Reemplaza al viejo método "responder". 
     * Guarda el mensaje en la sesión y redirige a la vista correspondiente.
     */
    private function redirigir(string $url, string $tipo, string $mensaje): void
    {
        $_SESSION['status_tipo']    = $tipo;
        $_SESSION['status_mensaje'] = $mensaje;
        header("Location: " . $url);
        exit;
    }
}

// ===== Ejecución =====
$controller = new AuthController();
$controller->manejarPeticion();