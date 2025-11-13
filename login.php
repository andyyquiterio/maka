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
<style>
  :root{
    --bg-overlay: rgba(0,0,0,0.65);
    --input-bg: rgba(255,255,255,0.95);
    --accent: #94b49f; /* verde del proyecto */
    --muted: rgba(255,255,255,0.85);
    --radius: 14px;
    --gap: 14px;
    --max-width: 420px;
    font-family: 'Poppins', sans-serif; /* fuente del proyecto */
  }

  /* Reset básico */
  *{box-sizing: border-box}
  html,body{height:100%;margin:0}
  body{
    min-height:100%;
    background-image: url('imagenes/headerimg.jpg'); /* imagen del proyecto */
    background-size: cover;
    background-position: center;
    color: white;
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
  }

  /* Overlay oscuro para que el texto contraste */
  .overlay{
    min-height:100vh;
    background: linear-gradient(var(--bg-overlay), var(--bg-overlay));
    display:flex;
    align-items:center;
    justify-content:center;
    padding:32px 18px;
  }

  /* Card contenedor */
  .card{
    width:100%;
    max-width: var(--max-width);
    padding:28px;
    border-radius:18px;
    display:flex;
    flex-direction:column;
    gap: var(--gap);
    /* transparente para mantener fondo */
    background: linear-gradient(rgba(0,0,0,0.00), rgba(0,0,0,0.00));
  }

  /* Titular grande */
  .title{
    font-size: clamp(20px, 5vw, 30px);
    font-weight:700;
    line-height:1.05;
    margin:0 0 6px 0;
    color: white;
    text-shadow: 0 2px 8px rgba(0,0,0,0.6);
  }

  .subtitle{
    font-size:14px;
    color:var(--muted);
    margin:0 0 12px 0;
  }

  form{display:flex;flex-direction:column;gap:12px}

  .field{
    display:flex;
    flex-direction:column;
    gap:8px;
  }

  label{
    font-size:13px;
    color: var(--muted);
    margin-left:6px;
  }

  input[type="text"], input[type="password"]{
    width:100%;
    padding:14px 16px;
    border-radius:12px;
    border: none;
    background: var(--input-bg);
    font-size:15px;
    outline: none;
    box-shadow: 0 6px 18px rgba(0,0,0,0.35) inset;
  }

  /* Contenedor de contraseña con icono */
  .pass-row{
    position:relative;
    display:flex;
    align-items:center;
  }

  .toggle-pass{
    position:absolute;
    right:10px;
    background:transparent;
    border:none;
    font-size:16px;
    cursor:pointer;
    padding:6px;
    color: rgba(0,0,0,0.6);
  }

  /* Botón principal */
  .btn{
    margin-top:6px;
    width:100%;
    padding:14px;
    border-radius:12px;
    border:none;
    background: var(--accent);
    color:white;
    font-weight:600;
    font-size:15px;
    cursor:pointer;
    box-shadow: 0 8px 24px rgba(0,0,0,0.45);
  }

  /* Botón secundario */
  .btn-secondary{
    background: transparent;
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
  }

  /* Desktop layout */
  @media(min-width:900px){
    .card{
      background: linear-gradient(0deg, rgba(0,0,0,0.25), rgba(0,0,0,0.15));
      padding:36px;
      border-radius:20px;
    }
    body{background-position: center right}
  }

  /* Pequeñas mejoras visuales */
  ::placeholder{color: rgba(0,0,0,0.45); font-weight:500}
</style>
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