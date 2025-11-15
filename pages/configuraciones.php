<?php
require_once __DIR__ . '/../config/conexion.php';
// Verificación de sesión
if (!isset($_SESSION['logged_in'])) {
    header('Location: ?page=login');
    exit;
}
// helper de escape
function esc($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configuraciones - Maka Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Encabezado de Configuraciones -->
  <div class="config-header">
    <div class="d-flex align-items-center">
      <a href="?page=dashboard" class="btn btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
      </a>
      <div class="text-center flex-grow-1">
        <i class="bi bi-gear-fill text-success" style="font-size: 2rem;"></i>
        <h4 class="mt-2 mb-0 fw-bold text-success">Configuraciones</h4>
      </div>
    </div>
  </div>

  <div class="container-fluid p-4">
    <div class="row g-4">

      <!-- Sección General -->
      <div class="col-lg-4 col-md-6">
        <div class="card config-card h-100">
          <div class="card-header bg-success text-white text-center">
            <h5 class="mb-0"><i class="bi bi-house me-2"></i>General</h5>
          </div>
          <div class="card-body">
            <a href="?page=cuenta" class="config-btn">
              <i class="bi bi-person config-icon"></i>Perfil
            </a>
            <a href="?page=notificaciones" class="config-btn">
              <i class="bi bi-bell config-icon"></i>Notificaciones
            </a>
          </div>
        </div>
      </div>

      <!-- Sección Cuenta -->
      <div class="col-lg-4 col-md-6">
        <div class="card config-card h-100">
          <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Cuenta</h5>
          </div>
          <div class="card-body">
            <a href="#" class="config-btn">
              <i class="bi bi-arrow-repeat config-icon"></i>Cambiar Cuenta
            </a>
            <a href="?logout=1" class="config-btn">
              <i class="bi bi-box-arrow-right config-icon"></i>Cerrar Sesión
            </a>
          </div>
        </div>
      </div>

      <!-- Sección Accesibilidad -->
      <div class="col-lg-4 col-md-6">
        <div class="card config-card h-100">
          <div class="card-header bg-info text-white text-center">
            <h5 class="mb-0"><i class="bi bi-universal-access me-2"></i>Accesibilidad</h5>
          </div>
          <div class="card-body">
            <a href="?page=reportar_falla" class="config-btn">
              <i class="bi bi-exclamation-triangle config-icon"></i>Reportar Falla
            </a>
            <a href="#" class="config-btn">
              <i class="bi bi-file-text config-icon"></i>Términos y Condiciones
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>