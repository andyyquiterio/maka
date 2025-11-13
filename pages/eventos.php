<?php
require_once __DIR__ . '/../config/conexion.php';
// Verificación de sesión
if (!isset($_SESSION['logged_in'])) {
    header('Location: ?page=login');
    exit;
}
// helper de escape
function esc($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

// Manejo de POST para crear evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_event'])) {
    $bride = trim($_POST['bride_name'] ?? '');
    $groom = trim($_POST['groom_name'] ?? '');
    $date = trim($_POST['date_event'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $status = trim($_POST['status'] ?? 'pending');

    if ($bride && $groom && $date && $location) {
        $stmt = $conn->prepare("INSERT INTO eventos (bride_name, groom_name, date_event, location, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $bride, $groom, $date, $location, $status);
        if ($stmt->execute()) {
            header('Location: ?page=eventos&saved=1');
            exit;
        } else {
            $error = "Error al crear evento.";
        }
        $stmt->close();
    } else {
        $error = "Todos los campos son requeridos.";
    }
}

// Manejo de eliminación
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM eventos WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header('Location: ?page=eventos&deleted=1');
        exit;
    } else {
        $error = "Error al eliminar evento.";
    }
    $stmt->close();
}

// Obtener eventos (simulado sin BD)
$eventos = []; // Array vacío por ahora
?>
<h4><i class="bi bi-calendar-event me-2 text-primary"></i>Eventos</h4>
<p class="text-muted">Gestiona los eventos en curso, próximos y pasados.</p>

<?php if (isset($_GET['saved'])): ?>
<div class="alert alert-success">Evento creado exitosamente.</div>
<?php endif; ?>
<?php if (isset($_GET['deleted'])): ?>
<div class="alert alert-success">Evento eliminado exitosamente.</div>
<?php endif; ?>
<?php if (isset($error)): ?>
<div class="alert alert-danger"><?php echo esc($error); ?></div>
<?php endif; ?>

<!-- Formulario de creación -->
<div class="card p-4 mb-4">
  <h5>Crear Nuevo Evento</h5>
  <form method="POST">
    <div class="row g-3">
      <div class="col-md-6">
        <label for="bride_name" class="form-label">Nombre de la Novia</label>
        <input type="text" class="form-control" id="bride_name" name="bride_name" required>
      </div>
      <div class="col-md-6">
        <label for="groom_name" class="form-label">Nombre del Novio</label>
        <input type="text" class="form-control" id="groom_name" name="groom_name" required>
      </div>
      <div class="col-md-6">
        <label for="date_event" class="form-label">Fecha del Evento</label>
        <input type="date" class="form-control" id="date_event" name="date_event" required>
      </div>
      <div class="col-md-6">
        <label for="location" class="form-label">Ubicación</label>
        <input type="text" class="form-control" id="location" name="location" required>
      </div>
      <div class="col-md-6">
        <label for="status" class="form-label">Estado</label>
        <select class="form-select" id="status" name="status">
          <option value="pending">Pendiente</option>
          <option value="confirmed">Confirmado</option>
          <option value="completed">Completado</option>
        </select>
      </div>
    </div>
    <button type="submit" name="create_event" class="btn btn-primary mt-3">Crear Evento</button>
  </form>
</div>

<!-- Listado de eventos -->
<div class="card p-4">
  <h5>Lista de Eventos</h5>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Novia</th>
        <th>Novio</th>
        <th>Fecha</th>
        <th>Ubicación</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($eventos as $evento): ?>
      <tr>
        <td><?php echo esc($evento['id'] ?? '1'); ?></td>
        <td><?php echo esc($evento['bride_name'] ?? 'Nombre Novia'); ?></td>
        <td><?php echo esc($evento['groom_name'] ?? 'Nombre Novio'); ?></td>
        <td><?php echo esc($evento['date_event'] ?? date('Y-m-d')); ?></td>
        <td><?php echo esc($evento['location'] ?? 'Ubicación'); ?></td>
        <td><?php echo esc($evento['status'] ?? 'pending'); ?></td>
        <td>
          <a href="?page=eventos&action=delete&id=<?php echo $evento['id'] ?? '1'; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este evento?')">Eliminar</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
