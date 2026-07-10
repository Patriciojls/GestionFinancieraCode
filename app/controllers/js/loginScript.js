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
    const correo   = document.getElementById('inputEmail').value.trim();
    const password = document.getElementById('inputPass').value.trim();
    const alerta   = document.getElementById('loginAlert');
    const msg      = document.getElementById('loginAlertMsg');

    alerta.classList.remove('show');

    if (!correo || !password) {
        mostrarError('Completa todos los campos');
        return;
    }

    // Llama al controller PHP
    const formData = new FormData();
    formData.append('accion',   'login');
    formData.append('correo',   correo);
    formData.append('password', password);

    fetch('../controllers/AuthController.php', {
        method: 'POST',
        body:   formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.exito) {
            mostrarExito('Bienvenido ' + data.nombre + '. Redirigiendo...');
            setTimeout(() => {
                window.location.href = 'dashboard.php';
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
    const alerta = document.getElementById('loginAlert');
    const msg    = document.getElementById('loginAlertMsg');
    alerta.style.background  = 'rgba(220,53,69,.08)';
    alerta.style.borderColor = 'rgba(220,53,69,.25)';
    alerta.style.color       = '#c0392b';
    alerta.querySelector('i').className = 'fas fa-exclamation-circle';
    msg.textContent = mensaje;
    alerta.classList.add('show');
}

function mostrarExito(mensaje) {
    const alerta = document.getElementById('loginAlert');
    const msg    = document.getElementById('loginAlertMsg');
    alerta.style.background  = 'rgba(39,174,96,.08)';
    alerta.style.borderColor = 'rgba(39,174,96,.25)';
    alerta.style.color       = '#27ae60';
    alerta.querySelector('i').className = 'fas fa-check-circle';
    msg.textContent = mensaje;
    alerta.classList.add('show');
}


