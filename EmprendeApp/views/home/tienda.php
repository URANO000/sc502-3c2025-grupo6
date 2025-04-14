<?php ob_start(); ?>
<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!-- Encabezado: saludo y botón cerrar sesión -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">🛍️ Tienda de Productos</h2>
        <p class="text-muted mb-0">Hola, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?> 👋</p>
    </div>
    <a href="index.php?action=logout" class="btn btn-outline-danger">🚪 Cerrar sesión</a>
</div>

<!-- Productos -->
<div class="row">
    <?php foreach ($productos as $p): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <?php if ($p['imagen']): ?>
                    <img src="<?= htmlspecialchars($p['imagen']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($p['nombre']) ?></h5>
                    <p class="card-text"><?= substr(htmlspecialchars($p['descripcion']), 0, 80) ?>...</p>
                    <p class="mb-1"><strong>₡<?= number_format($p['precio'], 2) ?></strong></p>
                    <small class="text-muted">Por <?= htmlspecialchars($p['emprendedor']) ?? 'emprendedor' ?></small>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="index.php?action=ver-producto&id=<?= $p['id'] ?>" class="btn btn-acento w-100">Ver más</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
$contenido = ob_get_clean();
$titulo = "Tienda";
include 'views/layout.php';
?>
