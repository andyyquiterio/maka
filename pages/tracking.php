<?php
require_once __DIR__ . '/../config/conexion.php';
// Verificación de sesión
if (!isset($_SESSION['logged_in'])) {
    header('Location: ?page=login');
    exit;
}
// helper de escape
function esc($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

// Manejo de POST para registrar movimiento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_movement'])) {
    $product_name = trim($_POST['product_name'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $quantity = (int)($_POST['quantity'] ?? 0);
    $destination = trim($_POST['destination'] ?? '');

    if ($product_name && in_array($type, ['IN', 'OUT']) && $quantity > 0 && $destination) {
        // Simular registro sin BD por ahora
        $success = true; // Simular éxito
        if ($success) {
            header('Location: ?page=tracking&saved=1');
            exit;
        } else {
            $error = "Error al registrar movimiento.";
        }
    } else {
        $error = "Campos inválidos.";
    }
}

// Simular movimientos sin BD
$movimientos = []; // Array vacío por ahora
?>
<h4><i class="bi bi-truck me-2 text-warning"></i>Tracking de Envíos</h4>
<p class="text-muted">Aquí podrás revisar el estado de los pedidos a proveedores.</p>

<?php if (isset($_GET['saved'])): ?>
<div class="alert alert-success">Movimiento registrado exitosamente.</div>
<?php endif; ?>
<?php if (isset($error)): ?>
<div class="alert alert-danger"><?php echo esc($error); ?></div>
<?php endif; ?>

<!-- Formulario para registrar movimiento -->
<div class="card p-4 mb-4">
  <h5>Registrar Movimiento</h5>
  <form method="POST">
    <div class="row g-3">
      <div class="col-md-3">
        <label for="product_name" class="form-label">Producto</label>
        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Nombre del producto" required>
      </div>
      <div class="col-md-3">
        <label for="type" class="form-label">Tipo</label>
        <select class="form-select" id="type" name="type" required>
          <option value="IN">Entrada</option>
          <option value="OUT">Salida</option>
        </select>
      </div>
      <div class="col-md-3">
        <label for="quantity" class="form-label">Cantidad</label>
        <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
      </div>
      <div class="col-md-3">
        <label for="destination" class="form-label">Destino</label>
        <input type="text" class="form-control" id="destination" name="destination" required>
      </div>
    </div>
    <button type="submit" name="add_movement" class="btn btn-primary mt-3">Registrar Movimiento</button>
  </form>
</div>

<!-- Listado de movimientos -->
<div class="card p-4">
  <h5>Historial de Movimientos</h5>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Tipo</th>
        <th>Cantidad</th>
        <th>Destino</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($movimientos as $mov): ?>
      <tr>
        <td><?php echo esc($mov['product_name'] ?? 'N/A'); ?></td>
        <td><?php echo esc($mov['type'] ?? 'N/A'); ?></td>
        <td><?php echo esc($mov['quantity'] ?? '0'); ?></td>
        <td><?php echo esc($mov['destination'] ?? 'N/A'); ?></td>
        <td><?php echo esc($mov['created_at'] ?? date('Y-m-d H:i:s')); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
