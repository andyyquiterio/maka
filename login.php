<?php
session_start();

// Si ya está logueado, redirigir a dashboard
if (isset($_SESSION['logged_in'])) {
    header('Location: index.php?page=dashboard');
    exit;
}

// Manejo de POST para login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Credenciales de prueba
    if ($username === 'pp' && $password === '123') {
        $_SESSION['logged_in'] = true;
        header('Location: index.php?page=dashboard');
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Iniciar sesión - Maka Dashboard</title>
</head>
<body>
  <div class="overlay" role="main">
    <section class="card" aria-labelledby="login-title">

      <h1 id="login-title" class="title">¡Bienvenido a Maka!<br><small style="font-weight:500">Inicia sesión para continuar.</small></h1>
      <p class="subtitle">Ingresa tus credenciales</p>

      <?php if (isset($error)): ?>
      <div style="background: rgba(255,0,0,0.8); color: white; padding: 10px; border-radius: 8px; margin-bottom: 10px;">
        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
      </div>
      <?php endif; ?>

      <form id="loginForm" method="post">
        <div class="field">
          <label for="username">Usuario</label>
          <input id="username" name="username" type="text" autocomplete="username" placeholder="Usuario" required />
        </div>

        <div class="field">
          <label for="password">Contraseña</label>
          <div class="pass-row">
            <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Contraseña" required />
            <button type="button" class="toggle-pass" id="togglePass" aria-label="Mostrar contraseña">👁️</button>
          </div>
        </div>

        <button class="btn" type="submit">Iniciar Sesión</button>
      </form>

      <div style="text-align:center;color:var(--muted);margin-top:8px;font-size:13px">Credenciales de prueba: pp / 123</div>

      <div style="margin-top: 20px; text-align: center;">
        <a href="login_admin.php" class="btn btn-secondary">Acceso Administrativo</a>
      </div>

    </section>
  </div>

<script>
  // Toggle mostrar/ocultar contraseña
  (function(){
    const pass = document.getElementById('password');
    const btn = document.getElementById('togglePass');
    btn.addEventListener('click', function(){
      const isPw = pass.type === 'password';
      pass.type = isPw ? 'text' : 'password';
      btn.textContent = isPw ? '🙈' : '👁️';
      btn.setAttribute('aria-pressed', isPw ? "true": "false");
    });
  })();

  // Evitar enviar si faltan datos
  document.getElementById('loginForm').addEventListener('submit', function(e){
    const u = document.getElementById('username').value.trim();
    const p = document.getElementById('password').value.trim();
    if(!u || !p){
      e.preventDefault();
      alert('Por favor completa usuario y contraseña.');
    }
  });
</script>
</body>
</html>