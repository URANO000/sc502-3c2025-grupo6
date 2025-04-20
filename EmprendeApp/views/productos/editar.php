<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">✏️ Editar Producto</h2>
    <a href="index.php?action=dashboard-emprendedor" class="btn btn-outline-primary">🏠 Home</a>
</div>


<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="card p-4 shadow-sm">
            <form method="POST" action="index.php?action=editar-producto" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $producto['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Nombre del Producto</label>
                    <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <div class="input-group">
                        <span class="input-group-text">₡</span>
                        <input type="number" name="precio" class="form-control" step="0.01" value="<?= $producto['precio'] ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select" required>
                        <option value="1" <?= $producto['categoria_id'] == 1 ? 'selected' : '' ?>>Alimentos</option>
                        <option value="2" <?= $producto['categoria_id'] == 2 ? 'selected' : '' ?>>Artesanías</option>
                        <option value="3" <?= $producto['categoria_id'] == 3 ? 'selected' : '' ?>>Servicios</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen actual</label><br>
                    <?php if ($producto['imagen']): ?>
                        <img src="<?= $producto['imagen'] ?>" class="img-fluid rounded mb-2" style="max-height: 200px;">
                    <?php else: ?>
                        <p class="text-muted">No hay imagen cargada.</p>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cambiar imagen</label>
                    <input type="file" name="nueva_imagen" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-acento w-100">💾 Guardar Cambios</button>
            </form>
        </div>
    </div>
</div>

<?php
$contenido = ob_get_clean();
$titulo = "Editar Producto";
include 'views/layout.php';
?>
