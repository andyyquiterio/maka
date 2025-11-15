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