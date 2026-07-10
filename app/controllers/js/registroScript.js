// ===== MOSTRAR/OCULTAR CONTRASEÑA (reutiliza la misma lógica) =====
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

// ===== VALIDACIÓN Y REGISTRO =====
function handleRegistro() {
  const nombre        = document.getElementById('inputNombre').value.trim();
  const correo        = document.getElementById('inputEmail').value.trim();
  const password      = document.getElementById('inputPass').value.trim();
  const passwordConf  = document.getElementById('inputPassConfirm').value.trim();

  if (!nombre || !correo || !password || !passwordConf) {
    mostrarError('Completa todos los campos');
    return;
  }

  if (!correo.includes('@')) {
    mostrarError('Ingresa un correo electrónico válido');
    return;
  }

  if (password.length < 8) {
    mostrarError('La contraseña debe tener al menos 8 caracteres');
    return;
  }

  if (password !== passwordConf) {
    mostrarError('Las contraseñas no coinciden');
    return;
  }

  const formData = new FormData();
  formData.append('accion',   'registro');
  formData.append('nombre',   nombre);
  formData.append('correo',   correo);
  formData.append('password', password);

fetch('../controllers/AuthController.php', {
  method: 'POST',
  body:   formData
})
  .then(res => res.json())
  .then(data => {
    if (data.exito) {
      mostrarExito('Cuenta creada correctamente. Redirigiendo al login...');
      setTimeout(() => {
        window.location.href = 'login.html';
      }, 1500);
    } else {
      mostrarError(data.mensaje);
    }
  })
  .catch(() => {
    mostrarError('Error de conexión con el servidor');
  });
}

function mostrarError(mensaje) {
  const alerta = document.getElementById('registroAlert');
  const msg    = document.getElementById('registroAlertMsg');
  alerta.style.background  = 'rgba(220,53,69,.08)';
  alerta.style.borderColor = 'rgba(220,53,69,.25)';
  alerta.style.color       = '#c0392b';
  alerta.querySelector('i').className = 'fas fa-exclamation-circle';
  msg.textContent = mensaje;
  alerta.classList.add('show');
}

function mostrarExito(mensaje) {
  const alerta = document.getElementById('registroAlert');
  const msg    = document.getElementById('registroAlertMsg');
  alerta.style.background  = 'rgba(39,174,96,.08)';
  alerta.style.borderColor = 'rgba(39,174,96,.25)';
  alerta.style.color       = '#27ae60';
  alerta.querySelector('i').className = 'fas fa-check-circle';
  msg.textContent = mensaje;
  alerta.classList.add('show');
}