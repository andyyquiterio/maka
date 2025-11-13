<?php
require_once __DIR__ . '/../config/conexion.php';
// Verificación de sesión
if (!isset($_SESSION['logged_in'])) {
    header('Location: ?page=login');
    exit;
}
// helper de escape
function esc($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

// Manejo de POST para crear notificación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_notification'])) {
    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($title && $message) {
        $stmt = $conn->prepare("INSERT INTO notifications (title, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $message);
        if ($stmt->execute()) {
            header('Location: ?page=notificaciones&saved=1');
            exit;
        } else {
            $error = "Error al crear notificación.";
        }
        $stmt->close();
    } else {
        $error = "Título y mensaje son requeridos.";
    }
}

// Manejo de eliminación
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header('Location: ?page=notificaciones&deleted=1');
        exit;
    } else {
        $error = "Error al eliminar notificación.";
    }
    $stmt->close();
}

// Obtener notificaciones (simulado sin BD)
$notificaciones = []; // Array vacío por ahora
?>
<h4><i class="bi bi-bell-fill me-2 text-success"></i>Notificaciones</h4>
<p class="text-muted">Aquí podrás ver todas las alertas y actualizaciones de tus proveedores y clientes.</p>

<?php if (isset($_GET['saved'])): ?>
<div class="alert alert-success">Notificación creada exitosamente.</div>
<?php endif; ?>
<?php if (isset($_GET['deleted'])): ?>
<div class="alert alert-success">Notificación eliminada exitosamente.</div>
<?php endif; ?>
<?php if (isset($error)): ?>
<div class="alert alert-danger"><?php echo esc($error); ?></div>
<?php endif; ?>

<!-- Formulario de crear notificación -->
<div class="card p-4 mb-4">
  <h5>Crear Notificación</h5>
  <form method="POST">
    <div class="mb-3">
      <label for="title" class="form-label">Título</label>
      <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
      <label for="message" class="form-label">Mensaje</label>
      <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
    </div>
    <button type="submit" name="create_notification" class="btn btn-primary">Crear Notificación</button>
  </form>
</div>

<!-- Listado de notificaciones -->
<div class="card p-4">
  <h5>Lista de Notificaciones</h5>
  <div class="list-group">
    <?php foreach($notificaciones as $notif): ?>
    <div class="list-group-item d-flex justify-content-between align-items-start">
      <div>
        <h6 class="mb-1"><?php echo esc($notif['title'] ?? 'Notificación de Prueba'); ?></h6>
        <p class="mb-1"><?php echo esc($notif['message'] ?? 'Este es un mensaje de notificación de ejemplo.'); ?></p>
        <small class="text-muted"><?php echo esc($notif['created_at'] ?? date('Y-m-d H:i:s')); ?></small>
      </div>
      <a href="?page=notificaciones&action=delete&id=<?php echo $notif['id'] ?? '1'; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta notificación?')">Eliminar</a>
    </div>
    <?php endforeach; ?>
  </div>
</div>
