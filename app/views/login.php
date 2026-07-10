<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Captura temporal de mensajes (Flash memory)
$tipoMsg = $_SESSION['status_tipo'] ?? '';
$mensaje = $_SESSION['status_mensaje'] ?? '';
unset($_SESSION['status_tipo'], $_SESSION['status_mensaje']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Iniciar Sesión — GFI</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/styleGFI.css">
</head>
<body>
  <div class="login-wrapper">
    <div class="login-left">
      </div>

    <div class="login-right">
      <div class="login-form-wrapper">
        <h2 class="login-form-title">Bienvenido de nuevo</h2>
        <p class="login-form-subtitle">Ingresa tus credenciales para acceder a tu cuenta</p>

        <?php if ($tipoMsg === 'error'): ?>
          <div class="login-alert d-flex show" style="background: rgba(220,53,69,.08); border-color: rgba(220,53,69,.25); color: #c0392b;">
            <i class="fas fa-exclamation-circle mr-2 align-self-center"></i>
            <span><?php echo $mensaje; ?></span>
          </div>
        <?php elseif ($tipoMsg === 'exito'): ?>
          <div class="login-alert d-flex show" style="background: rgba(39,174,96,.08); border-color: rgba(39,174,96,.25); color: #27ae60;">
            <i class="fas fa-check-circle mr-2 align-self-center"></i>
            <span><?php echo $mensaje; ?></span>
          </div>
        <?php endif; ?>

        <form method="POST" action="../controllers/AuthController.php">
          <input type="hidden" name="accion" value="login">

          <label class="form-label-custom">Correo electrónico</label>
          <div class="input-icon-wrapper">
            <i class="fas fa-envelope input-icon"></i>
            <input type="email" class="form-input-custom" name="correo" placeholder="tucorreo@ejemplo.com" required>
          </div>

          <label class="form-label-custom">Contraseña</label>
          <div class="input-icon-wrapper" style="position:relative;">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" class="form-input-custom" id="inputPass" name="password" placeholder="••••••••" style="padding-right: 44px;" required>
            <button class="input-toggle-pass" onclick="togglePass()" id="togglePassBtn" type="button">
              <i class="fas fa-eye" id="passIcon"></i>
            </button>
          </div>

          <div class="form-options">
            <label class="form-check-label-custom">
              <input type="checkbox" class="form-check-input-custom" id="rememberMe" name="rememberMe"> Recordarme
            </label>
            <a href="#" class="form-forgot">¿Olvidaste tu contraseña?</a>
          </div>

          <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
          </button>
        </form>

        <div class="login-divider"><div class="login-divider-line"></div><span class="login-divider-text">o</span><div class="login-divider-line"></div></div>
        <a href="registro.php" class="btn-register"><i class="fas fa-user-plus mr-2"></i> Crear una cuenta nueva</a>
      </div>
    </div>
  </div>

  <script>
    // Único JS que queda exclusivamente para la UI del ojito (no toca el backend)
    function togglePass() {
      const input = document.getElementById('inputPass');
      const icon  = document.getElementById('passIcon');
      input.type = input.type === 'password' ? 'text' : 'password';
      icon.classList.toggle('fa-eye'); icon.classList.toggle('fa-eye-slash');
    }
  </script>
</body>
</html>