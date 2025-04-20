<?php ob_start(); ?>

<h2 class="text-center mb-4">👥 Usuarios Registrados</h2>
<a href="index.php?action=dashboard-admin" class="btn btn-secondary mb-3">← Volver al Panel</a>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Tipo</th>
                <th>Ubicación</th>
                <th>Registro</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['nombre']) ?></td>
                    <td><?= htmlspecialchars($u['correo']) ?></td>
                    <td><?= ucfirst($u['tipo']) ?></td>
                    <td><?= htmlspecialchars($u['ubicacion']) ?></td>
                    <td><?= $u['creado_en'] ?></td>
                    <td>
                        <?php if ($_SESSION['usuario']['id'] != $u['id']): ?>
                            <a href="index.php?action=eliminar-usuario&id=<?= $u['id'] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Eliminar este usuario?')">
                               🗑️ Eliminar
                            </a>
                        <?php else: ?>
                            <span class="text-muted">(Tú)</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
$contenido = ob_get_clean();
$titulo = "Usuarios del Sistema";
include 'views/layout.php';
?>

