// ===== MOSTRAR/OCULTAR CONTRASEÑA =====
function togglePass() {
  const input = document.getElementById('inputPass');
  const icon  = document.getElementById('passIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.replace('fa-eye', 'fa-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.replace('fa-eye-slash', 'fa-eye');
  }
}

// ===== VALIDACIÓN Y LOGIN =====
function handleLogin() {
  const email = document.getElementById('inputEmail').value.trim();
  const pass  = document.getElementById('inputPass').value.trim();
  const alert = document.getElementById('loginAlert');
  const msg   = document.getElementById('loginAlertMsg');

  // Resetear alerta
  alert.classList.remove('show');
  alert.style.background   = 'rgba(220,53,69,.08)';
  alert.style.borderColor  = 'rgba(220,53,69,.25)';
  alert.style.color        = '#c0392b';
  alert.querySelector('i').className = 'fas fa-exclamation-circle';

  // Validaciones
  if (!email || !pass) {
    msg.textContent = 'Por favor completa todos los campos.';
    alert.classList.add('show');
    return;
  }

  if (!email.includes('@')) {
    msg.textContent = 'Ingresa un correo electrónico válido.';
    alert.classList.add('show');
    return;
  }

  if (pass.length < 8) {
    msg.textContent = 'La contraseña debe tener al menos 8 caracteres.';
    alert.classList.add('show');
    return;
  }

  // Éxito — aquí conectarás con tu backend
  alert.style.background  = 'rgba(39,174,96,.08)';
  alert.style.borderColor = 'rgba(39,174,96,.25)';
  alert.style.color       = '#27ae60';
  alert.querySelector('i').className = 'fas fa-check-circle';
  msg.textContent = '✓ Credenciales correctas. Redirigiendo...';
  alert.classList.add('show');

  setTimeout(() => {
    window.location.href = 'index.html'; // cambia por tu dashboard
  }, 1500);
}

// ===== ENTER PARA HACER LOGIN =====
document.addEventListener('keydown', function(e) {
  if (e.key === 'Enter') handleLogin();
});