<?php
require_once __DIR__ . '/../config/conexion.php';
// Verificación de sesión
if (!isset($_SESSION['logged_in'])) {
    header('Location: ?page=login');
    exit;
}
// helper de escape
function esc($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

// Simular datos de usuario (sin BD)
$currentUser = [
    'name' => 'Andrea Rossi',
    'email' => 'andrea@maka.com',
    'phone' => '+52 123 456 7890',
    'avatar' => 'imagenes/headerimg.jpg'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi Cuenta - Maka Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
  <style>
    :root {
      --bg-main: #f6f5f0;
      --card-bg: #fefefc;
      --border-color: #ccd5ae;
      --accent: #a3b18a;
      --text-dark: #4a5d3a;
      --shadow: 0 4px 15px rgba(160, 177, 138, 0.2);
    }

    body {
      background: var(--bg-main);
      font-family: 'Poppins', sans-serif;
      color: var(--text-dark);
    }

    .account-header {
      background: linear-gradient(135deg, #e9edc9, #fefefc);
      padding: 1rem;
      border-bottom: 1px solid var(--border-color);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .account-card {
      background: var(--card-bg);
      border: 2px solid var(--border-color);
      border-radius: 15px;
      box-shadow: var(--shadow);
      margin-bottom: 1rem;
    }

    .avatar-container {
      text-align: center;
      margin: 2rem 0;
    }

    .avatar {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid var(--accent);
    }

    .info-item {
      display: flex;
      align-items: center;
      padding: 1rem;
      border-bottom: 1px solid #f0f0f0;
    }

    .info-item:last-child {
      border-bottom: none;
    }

    .info-icon {
      margin-right: 1rem;
      color: var(--accent);
      font-size: 1.2rem;
    }

    .btn-pill {
      border-radius: 999px;
      padding: 0.75rem 2rem;
      background: var(--accent);
      border: none;
      color: white;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-pill:hover {
      background: #8a9b7a;
      transform: translateY(-1px);
    }

    .btn-outline-pill {
      border-radius: 999px;
      padding: 0.75rem 2rem;
      border: 2px solid var(--accent);
      background: transparent;
      color: var(--accent);
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-outline-pill:hover {
      background: var(--accent);
      color: white;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="account-header">
    <div class="d-flex align-items-center">
      <a href="?page=configuraciones" class="btn btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
      </a>
      <div class="text-center flex-grow-1">
        <h5 class="mb-0 fw-bold text-success">Mi Cuenta</h5>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container-fluid p-3">

    <!-- Avatar Section -->
    <div class="avatar-container">
      <img src="<?php echo esc($currentUser['avatar']); ?>" alt="Avatar" class="avatar">
      <h4 class="mt-3"><?php echo esc($currentUser['name']); ?></h4>
    </div>

    <!-- Info Card -->
    <div class="account-card">
      <div class="info-item">
        <i class="bi bi-person info-icon"></i>
        <div>
          <strong>Nombre</strong><br>
          <span><?php echo esc($currentUser['name']); ?></span>
        </div>
      </div>
      <div class="info-item">
        <i class="bi bi-envelope info-icon"></i>
        <div>
          <strong>Email</strong><br>
          <span><?php echo esc($currentUser['email']); ?></span>
        </div>
      </div>
      <div class="info-item">
        <i class="bi bi-telephone info-icon"></i>
        <div>
          <strong>Teléfono</strong><br>
          <span><?php echo esc($currentUser['phone']); ?></span>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-grid gap-3">
      <a href="?page=cuenta_ajustes" class="btn btn-pill">Editar Datos</a>
      <button class="btn btn-outline-pill" onclick="handleLogout()">Cerrar Sesión</button>
    </div>

  </div>

  <script>
    // Función para cerrar sesión
    function handleLogout() {
      if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
        window.location.href = '?logout=1';
      }
    }
  </script>

</body>
</html>