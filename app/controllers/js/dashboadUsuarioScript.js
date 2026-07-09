function handleLogout() {
  fetch('../controllers/AuthController.php?accion=logout')
    .then(() => window.location.href = 'login.html')
    .catch(() => window.location.href = 'login.html');
}