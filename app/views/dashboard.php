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
      <button class="btn-login" style="width:auto; padding:.6rem 1.5rem;" onclick="handleLogout()">
        <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
      </button>
    </div>

    <!-- Navegación a secciones -->
    <div class="dashboard-nav" style="display:flex; gap:1rem; flex-wrap:wrap;">
      <a href="ingresos.html" class="btn-register" style="width:auto; padding:.8rem 1.5rem;">
        <i class="fas fa-wallet mr-2"></i> Ingresos
      </a>
      <a href="gastos.html" class="btn-register" style="width:auto; padding:.8rem 1.5rem;">
        <i class="fas fa-shopping-cart mr-2"></i> Gastos
      </a>
      <a href="deudas.html" class="btn-register" style="width:auto; padding:.8rem 1.5rem;">
        <i class="fas fa-file-invoice-dollar mr-2"></i> Deudas
      </a>
      <a href="metas.html" class="btn-register" style="width:auto; padding:.8rem 1.5rem;">
        <i class="fas fa-bullseye mr-2"></i> Metas
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