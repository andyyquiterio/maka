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

// Consultas para totales (simuladas sin BD)
$total_eventos = 5; // Simulado
$total_productos = 10; // Simulado
$total_unidades = 150; // Simulado
$ultimas_notificaciones = []; // Array vacío por ahora
?>
<!-- 🌷 Banner -->
$ultimas_notificaciones = $conn->query("SELECT title, message FROM notifications ORDER BY created_at DESC LIMIT 5");
?>
<!-- 🌳 BARRA DE NAVEGACIÓN SUPERIOR (Navbar) 
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Menú Hamburguesa -->
            <a href="#" class="fs-4"><i class="bi bi-list"></i></a>

            <!-- Perfil de Usuario --
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
                    <?php foreach($ultimas_notificaciones as $notif): ?>
                    <p class="small mb-1">
                        <i class="bi bi-dot me-1"></i>
                        <strong><?php echo esc($notif['title'] ?? 'Notificación'); ?>:</strong> <?php echo esc($notif['message'] ?? 'Mensaje de prueba'); ?>
                    </p>
                    <?php endforeach; ?>
                    
                    <?php if(empty($ultimas_notificaciones)): ?>
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
                    <img src="imagenes/check-box (1).png" alt="Icono inventario" class="icon-img">
                    <!-- Usamos 'text-tarjetas' para el color de título mapeado en styles.css -->
                    <h6 class="fw-bold text-tarjetas mt-2 mb-0">Inventario (<?php echo $total_unidades; ?>)</h6>
                </a>
            </div>
        </div>

  <!-- Eventos-->        
        <div class="col-lg-6 col-md-12">
    <div class="card p-4 card-borde-verde hover-card h-100 events-card" style="min-height: 220px;">
        <a href="index.php?page=eventos" class="text-decoration-none d-flex flex-column h-100">
            <h5 class="text-center fw-bold mb-3" style="color: var(--color-text-dark);">
                Eventos
            </h5>
            <h5 class="text-center fw-bold mb-4" style="color: var(--color-text-dark);">
                Boda "William y Pepa"
            </h5>
            
            <div class="row g-2 align-items-center flex-grow-1">
                
                <div class="col-6 d-flex flex-column align-items-center justify-content-center border-end border-opacity-25 border-tarjeta-evento">
                    <div class="text-center">
                        <img src="imagenes/calendario.png" alt="Calendario" class="custom-icon-img mb-2"> 
                        <p class="small text-muted mb-1 fw-semibold">15 de Diciembre 2025</p>
                    </div>
                    
                    <div class="text-center mt-3">
                        <img src="imagenes/reloj.png" alt="Reloj" class="custom-icon-img mb-2">
                        <p class="small text-muted mb-0">
                            **12:00 hrs** - Inicio de Montaje<br>
                            **16:00 hrs** - Fin de Montaje<br>
                            **17:30 hrs** - Inicio de Evento
                        </p>
                    </div>
                </div>
                
                <div class="col-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="text-center">
                        <img src="imagenes/reloj.png" alt="Ubicación" class="custom-icon-img mb-2">
                        <p class="small text-muted mb-1 fw-semibold">15 de Diciembre 2025</p>
                    </div>
                    
                    <div class="text-center mt-3">
                        <img src="imagenes/reloj.png" alt="Invitados" class="custom-icon-img mb-2">
                        <p class="small text-muted mb-0">
                            **5000 invitados**
                        </p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

    </div>
</main>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>