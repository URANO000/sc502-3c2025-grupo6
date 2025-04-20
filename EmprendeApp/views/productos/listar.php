<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">📦 Mis Productos Publicados</h2>
    <a href="index.php?action=dashboard-emprendedor" class="btn btn-outline-primary">
        🏠 Home
    </a>
</div>

<a href="index.php?action=crear-producto" class="btn btn-acento mb-4">➕ Publicar nuevo producto</a>

<div class="row">
    <?php foreach ($productos as $p): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <?php if ($p['imagen']): ?>
                    <img src="<?= $p['imagen'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Imagen del producto">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($p['nombre']) ?></h5>
                    <p class="card-text text-muted mb-1">Categoría: <?= htmlspecialchars($p['categoria']) ?? 'N/A' ?></p>
                    <p class="card-text"><strong>₡<?= number_format($p['precio'], 2) ?></strong></p>
                </div>
                <div class="card-footer bg-white border-top-0 d-flex justify-content-between">
                    
                    <a href="index.php?action=editar-producto&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-warning">✏️ Editar</a>
                    <a href="index.php?action=eliminar-producto&id=<?= $p['id'] ?>"
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('¿Eliminar este producto?')">🗑️ Eliminar</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
$contenido = ob_get_clean();
$titulo = "Mis Productos";
include 'views/layout.php';
?>


