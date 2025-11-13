<?php
// ---------------------------------------------------------------------------
// Header: inicialización de sesión y obtención del nombre de usuario
// Comentario: este bloque garantiza que haya una sesión activa y que la
// variable `$user` contenga el nombre para mostrar en el header.
// ---------------------------------------------------------------------------
$user = 'Admin';
if (session_status() === PHP_SESSION_NONE) session_start();
// Si existen variables de sesión con diferentes keys, usar la disponible
if (isset($_SESSION['user_name'])) $user = $_SESSION['user_name'];
if (isset($_SESSION['username'])) $user = $_SESSION['username'];
?>

<!-- ---------------------------------------------------------------------- -->
<!-- Barra superior (header)                                                  -->
<!-- Comentario: `top-bar` es la barra fija superior; contiene marca,        -->
<!-- navegación principal, información del usuario y botón de logout.       -->
<!-- ---------------------------------------------------------------------- -->
<nav class="top-bar navbar navbar-expand fixed-top">
  <div class="container-fluid d-flex align-items-center">

    <!-- Marca/Nombre de la aplicación -->
    <a class="navbar-brand text-white fw-bold" href="index.php">Maka Dashboard</a>

    <!-- Inicio: Navegación principal en el header -->
    <!-- Comentario: cada enlace usa la clase `animated-btn` definida en CSS -->
    <!-- para aplicar la animación y la transición solicitada. -->
    <ul class="navbar-nav ms-3 me-auto d-flex flex-row">
      <li class="nav-item">
        <!-- Dashboard: link principal -->
        <a class="nav-link animated-btn text-white px-2" href="index.php?page=dashboard">
          <i class="bi bi-house me-1"></i>Dashboard
        </a>
      </li>
      <li class="nav-item">
        <!-- Notificaciones -->
        <a class="nav-link animated-btn text-white px-2" href="index.php?page=notificaciones">
          <i class="bi bi-bell me-1"></i>Notificaciones
        </a>
      </li>
      <li class="nav-item">
        <!-- Eventos -->
        <a class="nav-link animated-btn text-white px-2" href="index.php?page=eventos">
          <i class="bi bi-calendar-event me-1"></i>Eventos
        </a>
      </li>
      <li class="nav-item">
        <!-- Tracking -->
        <a class="nav-link animated-btn text-white px-2" href="index.php?page=tracking">
          <i class="bi bi-truck me-1"></i>Tracking
        </a>
      </li>
      <li class="nav-item">
        <!-- Catálogo -->
        <a class="nav-link animated-btn text-white px-2" href="index.php?page=catalogo">
          <i class="bi bi-book me-1"></i>Catálogo
        </a>
      </li>
      <li class="nav-item">
        <!-- Configuraciones (ejemplo) -->
        <a class="nav-link animated-btn text-white px-2" href="index.php?page=configuraciones">
          <i class="bi bi-gear me-2"></i>Configuraciones
        </a>
      </li>
    </ul>
    <!-- Fin: Navegación principal en el header -->

    <!-- Inicio: Panel derecho con usuario y logout -->
    <div class="ms-auto d-flex align-items-center gap-3">
      <!-- Mostrar nombre de usuario (escape para seguridad) -->
      <span class="text-white small"><?php echo htmlspecialchars($user); ?></span>

      <!-- Avatar del usuario: imagen redondeada -->
      <img src="imagenes/headerimg.jpg" alt="User" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;">

      <!-- Botón Salir: usa la misma clase `animated-btn` para apariencia uniforme -->
      <a href="?logout=1" class="btn btn-outline-light btn-sm animated-btn">Salir</a>
    </div>
    <!-- Fin: Panel derecho con usuario y logout -->

  </div>
</nav>

