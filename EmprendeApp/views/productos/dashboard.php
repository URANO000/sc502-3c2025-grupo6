<?php ob_start(); ?>
<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!-- Encabezado superior -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">📊 Panel del Emprendedor</h2>
        <p class="text-muted mb-0">Hola, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?> 👋</p>
    </div>
    <a href="index.php?action=logout" class="btn btn-outline-danger">🚪 Cerrar sesión</a>
</div>

<!-- Contenido del panel -->
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4 shadow-sm">
            <h4 class="text-center mb-3">¿Qué te gustaría hacer?</h4>

            <div class="list-group mt-2">
                <a href="index.php?action=mis-productos" class="list-group-item list-group-item-action">
                    📦 Ver Mis Productos
                </a>
                <a href="index.php?action=crear-producto" class="list-group-item list-group-item-action">
                    ➕ Crear Nuevo Producto
                </a>
                <a href="index.php?action=ver-preguntas" class="list-group-item list-group-item-action">
                    🗨️ Ver Preguntas Recibidas
                </a>
                <a href="index.php?action=estadisticas" class="list-group-item list-group-item-action">
                    📈 Ver Estadísticas
</a>

            </div>
        </div>
    </div>
</div>

<?php
$contenido = ob_get_clean();
$titulo = "Dashboard Emprendedor";
include 'views/layout.php';
?>

