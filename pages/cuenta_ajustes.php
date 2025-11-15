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

// Manejo de POST para guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    $errors = [];

    if (!$name) $errors[] = "El nombre es requerido.";
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email válido requerido.";
    if (!$phone) $errors[] = "El teléfono es requerido.";
    if ($new_password && $new_password !== $confirm_password) $errors[] = "Las contraseñas no coinciden.";

    if (empty($errors)) {
        // Simular guardado exitoso
        $success = "Cambios guardados exitosamente.";
        // Actualizar datos simulados
        $currentUser['name'] = $name;
        $currentUser['email'] = $email;
        $currentUser['phone'] = $phone;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajustes de Cuenta - Maka Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Header -->
  <div class="account-header">
    <div class="d-flex align-items-center">
      <a href="?page=cuenta" class="btn btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
      </a>
      <div class="text-center flex-grow-1">
        <h5 class="mb-0 fw-bold text-success">Ajustes de Cuenta</h5>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container-fluid p-3">

    <?php if (isset($success)): ?>
    <div class="alert alert-success"><?php echo esc($success); ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach($errors as $error): ?>
        <li><?php echo esc($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

      <!-- Avatar Upload -->
      <div class="account-card p-3">
        <div class="avatar-upload">
          <img src="<?php echo esc($currentUser['avatar']); ?>" alt="Avatar" class="avatar-preview" id="avatarPreview">
          <br>
          <label for="avatarInput" class="file-label">
            <i class="bi bi-camera me-1"></i>Cambiar Foto
          </label>
          <input type="file" id="avatarInput" class="file-input" accept="image/*" onchange="previewAvatar(this)">
        </div>
      </div>

      <!-- Información Personal -->
      <div class="account-card p-3">
        <h6 class="mb-3 fw-bold">Información Personal</h6>

        <div class="form-group">
          <label for="name" class="form-label">Nombre Completo</label>
          <input type="text" class="form-control" id="name" name="name" value="<?php echo esc($currentUser['name']); ?>" required>
        </div>

        <div class="form-group">
          <label for="email" class="form-label">Correo Electrónico</label>
          <div class="input-group">
            <input type="email" class="form-control" id="email" name="email" value="<?php echo esc($currentUser['email']); ?>" required>
            <span class="input-icon"><i class="bi bi-envelope"></i></span>
          </div>
        </div>

        <div class="form-group">
          <label for="phone" class="form-label">Teléfono</label>
          <div class="input-group">
            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo esc($currentUser['phone']); ?>" required>
            <span class="input-icon"><i class="bi bi-telephone"></i></span>
          </div>
        </div>
      </div>

      <!-- Seguridad -->
      <div class="account-card p-3">
        <h6 class="mb-3 fw-bold">Seguridad</h6>

        <div class="form-group">
          <label for="new_password" class="form-label">Nueva Contraseña (opcional)</label>
          <div class="input-group">
            <input type="password" class="form-control" id="new_password" name="new_password">
            <span class="input-icon" onclick="togglePassword('new_password')"><i class="bi bi-eye" id="eye_new"></i></span>
          </div>
        </div>

        <div class="form-group">
          <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
          <div class="input-group">
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            <span class="input-icon" onclick="togglePassword('confirm_password')"><i class="bi bi-eye" id="eye_confirm"></i></span>
          </div>
        </div>
      </div>

      <!-- Botón Guardar -->
      <div class="d-grid">
        <button type="submit" name="save_changes" class="btn btn-pill">Guardar Cambios</button>
      </div>

    </form>

  </div>

  <script>
    // Función para previsualizar avatar
    function previewAvatar(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('avatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    // Función para mostrar/ocultar contraseña
    function togglePassword(fieldId) {
      const field = document.getElementById(fieldId);
      const eyeIcon = document.getElementById('eye_' + fieldId.split('_')[1]);

      if (field.type === 'password') {
        field.type = 'text';
        eyeIcon.className = 'bi bi-eye-slash';
      } else {
        field.type = 'password';
        eyeIcon.className = 'bi bi-eye';
      }
    }

    // Validación del formulario
    document.querySelector('form').addEventListener('submit', function(e) {
      const newPass = document.getElementById('new_password').value;
      const confirmPass = document.getElementById('confirm_password').value;

      if (newPass && newPass !== confirmPass) {
        e.preventDefault();
        alert('Las contraseñas no coinciden.');
      }
    });
  </script>

</body>
</html>