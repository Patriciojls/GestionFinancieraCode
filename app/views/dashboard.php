<?php
session_start();

// Protege la página: si no hay sesión activa, manda a login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Dashboard — GFI</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/styleGFI.css">
</head>

<body>
  <div class="dashboard-wrapper" style="padding:2rem;">

    <div class="dashboard-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
      <div>
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
        <p style="color:#888;">Tu plataforma de gestión financiera</p>
      </div>


      <form method="POST" action="../controllers/AuthController.php" style="display: inline;">
    <input type="hidden" name="accion" value="logout">
    <button type="submit" class="btn-login" style="width:auto; padding:.6rem 1.5rem;">
        <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión

        
    </button>
</form>
    </div>

    <!-- Navegación a secciones -->
    <div class="dashboard-nav" style="display:flex; gap:1rem; flex-wrap:wrap;">

      <a href="demo-cruds/valentincrud.html" class="btn-register" style="width:auto; padding:.8rem 1.5rem;">
        <i class="fas fa-wallet mr-2"></i> Mi membresia 
      </a>
      <a href="demo-cruds/aldrickcrud.html" class="btn-register" style="width:auto; padding:.8rem 1.5rem;">
        <i class="fas fa-wallet mr-2"></i> Ingresos
      </a>
      <a href="gastos.html" class="btn-register" style="width:auto; padding:.8rem 1.5rem;">
        <i class="fas fa-shopping-cart mr-2"></i> Egresos
      </a>
      <a href="demo-cruds/azrielcrud.html" class="btn-register" style="width:auto; padding:.8rem 1.5rem;">
        <i class="fas fa-file-invoice-dollar mr-2"></i> Deudas
      </a>
      <a href="demo-cruds/anitacrud.html" class="btn-register" style="width:auto; padding:.8rem 1.5rem;">
        <i class="fas fa-bullseye mr-2"></i> Metas
      </a>
      <a href="demo-cruds/patriciocrud.html" class="btn-register" style="width:auto; padding:.8rem 1.5rem;">
        <i class="fas fa-quote-right mr-2"></i> Testimonios
      </a>
    </div>

    <p style="margin-top:2rem; color:#888;">
      Aquí verás pronto un resumen de tus ingresos, gastos, deudas y metas.
    </p>

  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="../controllers/js/dashboardUsuarioScript.js"></script>
</body>
</html>