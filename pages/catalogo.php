  <?php
  require_once __DIR__ . '/../config/conexion.php';
  // Verificación de sesión
  if (!isset($_SESSION['logged_in'])) {
      header('Location: ?page=login');
      exit;
  }
  // helper de escape
  function esc($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

  // Manejo de POST para agregar producto
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
      $code = trim($_POST['code'] ?? '');
      $name = trim($_POST['name'] ?? '');
      $category = trim($_POST['category'] ?? '');
      $price = (float)($_POST['price'] ?? 0);

      if ($code && $name && $category && $price > 0) {
          $stmt = $conn->prepare("INSERT INTO products (code, name, category, price) VALUES (?, ?, ?, ?)");
          $stmt->bind_param("sssd", $code, $name, $category, $price);
          if ($stmt->execute()) {
              header('Location: ?page=catalogo&saved=1');
              exit;
          } else {
              $error = "Error al agregar producto.";
          }
          $stmt->close();
      } else {
          $error = "Todos los campos son requeridos y precio debe ser mayor a 0.";
      }
  }

  // Obtener productos (simulado sin BD)
  $productos = []; // Array vacío por ahora
  ?>
  <h4><i class="bi bi-book me-2 text-primary"></i>Catálogo</h4>
  <p class="text-muted">Gestiona el catálogo de productos.</p>

  <?php if (isset($_GET['saved'])): ?>
  <div class="alert alert-success">Producto agregado exitosamente.</div>
  <?php endif; ?>
  <?php if (isset($error)): ?>
  <div class="alert alert-danger"><?php echo esc($error); ?></div>
  <?php endif; ?>

  <!-- Formulario de agregar producto -->
  <div class="card p-4 mb-4">
    <h5>Agregar Producto</h5>
    <form method="POST">
      <div class="row g-3">
        <div class="col-md-3">
          <label for="code" class="form-label">Código</label>
          <input type="text" class="form-control" id="code" name="code" required>
        </div>
        <div class="col-md-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="col-md-3">
          <label for="category" class="form-label">Categoría</label>
          <input type="text" class="form-control" id="category" name="category" required>
        </div>
        <div class="col-md-3">
          <label for="price" class="form-label">Precio</label>
          <input type="number" step="0.01" class="form-control" id="price" name="price" required>
        </div>
      </div>
      <button type="submit" name="add_product" class="btn btn-primary mt-3">Agregar Producto</button>
    </form>
  </div>

  <!-- Listado de productos en cards -->
  <div class="row g-3">
    <?php foreach($productos as $prod): ?>
    <div class="col-md-4">
      <div class="card p-3 text-center">
        <img src="imagenes/placeholder.png" alt="Producto" class="card-img-top" style="height: 150px; object-fit: cover;">
        <div class="card-body">
          <h6 class="card-title"><?php echo esc($prod['name'] ?? 'Producto de Prueba'); ?></h6>
          <p class="card-text"><?php echo esc($prod['category'] ?? 'Categoría'); ?> - $<?php echo esc($prod['price'] ?? '0.00'); ?></p>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?php echo $prod['id'] ?? '1'; ?>">Ver</button>
        </div>
      </div>
    </div>

    <!-- Modal para detalles -->
    <div class="modal fade" id="modal<?php echo $prod['id'] ?? '1'; ?>" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><?php echo esc($prod['name'] ?? 'Producto de Prueba'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <p><strong>Código:</strong> <?php echo esc($prod['code'] ?? 'COD001'); ?></p>
            <p><strong>Categoría:</strong> <?php echo esc($prod['category'] ?? 'Categoría'); ?></p>
            <p><strong>Precio:</strong> $<?php echo esc($prod['price'] ?? '0.00'); ?></p>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
