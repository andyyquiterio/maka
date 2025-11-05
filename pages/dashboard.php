<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Gestión de Eventos</title>
    <!-- Carga de Bootstrap CSS (Grid y Utilidades) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Carga de Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <!-- ENLACE AL ARCHIVO CSS SEPARADO -->
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>

<?php
require_once __DIR__ . '/../config/conexion.php';
// Verificación de sesión
if (!isset($_SESSION['logged_in'])) {
    header('Location: ?page=login');
    exit;
}
// helper de escape
function esc($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

// Consultas para totales
$total_eventos = $conn->query("SELECT COUNT(*) as total FROM eventos")->fetch_assoc()['total'];
$total_productos = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];
$total_unidades = $conn->query("SELECT SUM(quantity) as total FROM inventory")->fetch_assoc()['total'] ?? 0;
$ultimas_notificaciones = $conn->query("SELECT title, message FROM notifications ORDER BY created_at DESC LIMIT 5");
?>
<!-- 🌷 Banner -->
$ultimas_notificaciones = $conn->query("SELECT title, message FROM notifications ORDER BY created_at DESC LIMIT 5");
?>
<!-- 🌳 BARRA DE NAVEGACIÓN SUPERIOR (Navbar) 
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Menú Hamburguesa -->
            <a href="#" class="fs-4"><i class="bi bi-list"></i></a>

            <!-- Perfil de Usuario -->
            <div class="d-flex align-items-center">
                <a href="index.php?page=perfil" class="text-decoration-none d-flex align-items-center">
                    <i class="bi bi-person-circle fs-3 me-2"></i>
                </a>
            </div>

            <!-- Notificación (Campana) -->
            <a href="index.php?page=notificaciones" class="fs-4"><i class="bi bi-bell"></i></a>
        </div>
    </header>
    
    <main class="container py-4">

    <!-- 🌷 Banner -->
    <div class="dashboard-banner p-4 mb-4 text-white rounded" 
         style="background: url('imagenes/headerimg.jpg') center/cover;">
        <h4>Bienvenida de nuevo, Andrea <span role="img" aria-label="heart emoji">💕</span></h4>
        <p>Organiza, visualiza y gestiona todos tus eventos fácilmente.</p>
    </div>

    <!-- 🌳 CONTENIDO PRINCIPAL (Usando la estructura de columnas de tu snippet) 🌳 -->
    <div class="row g-3">
        
        <!-- 🔔 Notificaciones (col-lg-6) -->
        <div class="col-lg-6 col-md-6">
            <!-- Aplicamos 'notif-card' para el color de fondo verde -->
            <div class="card p-3 card-borde-verde hover-card h-100 notif-card"> 
                <a href="index.php?page=notificaciones" class="text-decoration-none">
                    <!-- Usamos 'custom-text' para el color de título mapeado en styles.css -->
                    <h6 class="fw-bold mb-2 custom-text">
                        <i class="bi bi-bell-fill me-2"></i>NOTIFICACIONES RECIENTES
                    </h6>
                    <?php while($notif = $ultimas_notificaciones->fetch_assoc()): ?>
                    <p class="small mb-1">
                        <i class="bi bi-dot me-1"></i>
                        <strong><?php echo esc($notif['title']); ?>:</strong> <?php echo esc($notif['message']); ?>
                    </p>
                    <?php endwhile; ?>
                    
                    <?php if($ultimas_notificaciones->num_rows == 0): ?>
                    <p class="small mb-0">No hay notificaciones recientes.</p>
                    <?php endif; ?>
                </a>
            </div>
        </div>

        <!-- 🚚 Seguimiento (col-lg-6) -->
        <div class="col-lg-6 col-md-6">
            <!-- Aplicamos 'tracking-card' para el color de fondo beige y añadimos la barra de progreso -->
            <div class="card p-3 card-borde-verde hover-card h-100 tracking-card">
                <a href="index.php?page=tracking" class="text-decoration-none">
                    <!-- Usamos 'text-warning' para el color del título mapeado en styles.css -->
                    <h6 class="fw-bold mb-2 text-warning">
                        <i class="bi bi-truck me-2"></i>SEGUIMIENTO DE PEDIDOS
                    </h6>
                    <p class="small text-muted mb-0">
                        El pedido de flores está en camino <span role="img" aria-label="flower emoji">🌸</span>
                    </p>
                </a>
                <!-- Barra de progreso para el diseño visual -->
                <div class="progress-container mb-1 mt-3">
                    <div class="progress-bar-custom" style="width: 65%;"></div>
                </div>
                <div class="d-flex justify-content-between small text-muted">
                    <span>Procesando</span>
                    <span>En Camino</span>
                </div>
            </div>
        </div>

        <!-- 📔 Catálogo (col-lg-3) -->
        <div class="col-lg-3 col-md-6">
            <!-- Aplicamos 'quick-access-card' para el centrado vertical y horizontal -->
            <div class="card p-4 card-borde-verde hover-card text-center quick-access-card">
                <a href="index.php?page=catalogo" class="text-decoration-none d-flex flex-column align-items-center">
                    <!-- Usamos 'icon-img' de styles.css para el tamaño -->
                    <img src="imagenes/open-book (1).png" alt="Icono catálogo" class="icon-img">
                    <!-- Usamos 'text-tarjetas' para el color de título mapeado en styles.css -->
                    <h6 class="fw-bold text-tarjetas mt-2 mb-0">Catálogo (<?php echo $total_productos; ?>)</h6>
                </a>
            </div>
        </div>

        <!-- 📦 Inventario (col-lg-3) -->
        <div class="col-lg-3 col-md-6">
            <!-- Aplicamos 'quick-access-card' para el centrado vertical y horizontal -->
            <div class="card p-4 card-borde-verde hover-card text-center quick-access-card">
                <a href="index.php?page=inventario" class="text-decoration-none d-flex flex-column align-items-center">
                    <!-- Usamos 'icon-img' de styles.css para el tamaño -->
                    <img src="imagenes/box.png" alt="Icono inventario" class="icon-img">
                    <!-- Usamos 'text-tarjetas' para el color de título mapeado en styles.css -->
                    <h6 class="fw-bold text-tarjetas mt-2 mb-0">Inventario (<?php echo $total_unidades; ?>)</h6>
                </a>
            </div>
        </div>

        <!-- 📅 Eventos (col-lg-6 - abarca el espacio completo a la derecha) -->
        <div class="col-lg-6 col-md-12">
            <!-- Aplicamos 'events-card' para el color de fondo beige y h-100 -->
            <div class="card p-4 card-borde-verde hover-card h-100 events-card" style="min-height: 220px;">
                <a href="index.php?page=eventos" class="text-decoration-none">
                    <!-- Usamos 'text-primary' para el color de título mapeado en styles.css -->
                    <h6 class="fw-bold mb-3 text-primary">
                        <i class="bi bi-calendar-event me-2"></i>PRÓXIMOS EVENTOS (<?php echo $total_eventos; ?>)
                    </h6>
                    <!-- El ul se usa con las clases de events-card en styles.css para los puntos -->
                    <ul class="small text-muted mb-0 ps-3">
                        <li>12:00 - Llegada invitados</li>
                        <li>13:30 - Ceremonia civil</li>
                        <li>14:00 - Cóctel y Fotos</li>
                        <!-- Aquí puedes continuar la lista de tu evento -->
                    </ul>
                </a>
            </div>
        </div>

    </div>
</main>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>