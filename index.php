<?php
session_start();

// Verificación de sesión: si no logueado, redirigir a login
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

// Manejar logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Detecta qué página se pidió (por URL)
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Maka Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <?php include 'sidebar.php'; ?>
  <div class="main-content">
    <?php include 'header.php'; ?>

    <div class="p-4">
      <?php include "pages/$page.php"; ?>
    </div>
  </div>

</body>
</html>
