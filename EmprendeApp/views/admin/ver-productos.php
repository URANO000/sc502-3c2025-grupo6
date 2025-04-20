<?php ob_start(); ?>

<h2 class="text-center mb-4">📦 Productos Publicados por Emprendedores</h2>
<a href="index.php?action=dashboard-admin" class="btn btn-secondary mb-3">← Volver al Panel</a>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Emprendedor</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= htmlspecialchars($p['categoria']) ?></td>
                    <td>₡<?= number_format($p['precio'], 2) ?></td>
                    <td><?= htmlspecialchars($p['descripcion']) ?></td>
                    <td><?= htmlspecialchars($p['emprendedor']) ?></td>
                    <td><?= $p['creado_en'] ?></td>
                    <td>
                        <a href="index.php?action=eliminar-producto-admin&id=<?= $p['id'] ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('¿Eliminar este producto?')">
                           🗑️ Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
$contenido = ob_get_clean();
$titulo = "Productos Publicados";
include 'views/layout.php';
?>
