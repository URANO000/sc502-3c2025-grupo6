<?php ob_start(); ?>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- 🔙 Botón Volver -->
            <a href="index.php?action=home" class="btn btn-outline-secondary mb-4">
                ⬅️ Volver a la tienda
            </a>

            <!-- 🛍️ Detalles del producto -->
            <div class="card mb-4 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-5">
                        <img src="<?= $producto['imagen'] ?>" class="img-fluid rounded-start w-100" style="object-fit: cover; height: 100%;">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h3 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h3>
                            <p class="text-muted">Categoría: <?= $producto['categoria'] ?></p>
                            <p class="card-text"><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
                            <h4 class="text-success mb-3">₡<?= number_format($producto['precio'], 2) ?></h4>
                            <p class="text-secondary">Publicado por: <?= $producto['autor'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ❓ Preguntas y respuestas -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">❓ Preguntas y Respuestas</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($preguntas)): ?>
                        <?php foreach ($preguntas as $q): ?>
                            <div class="mb-3 border-bottom pb-2">
                                <strong><?= $q['autor'] ?> preguntó:</strong><br>
                                <?= htmlspecialchars($q['mensaje']) ?><br>
                                <?php if ($q['respuesta']): ?>
                                    <div class="mt-1">
                                        <span class="text-success fw-semibold">Respuesta:</span> <?= htmlspecialchars($q['respuesta']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Aún no hay preguntas para este producto.</p>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['usuario'])): ?>
                        <form method="POST" action="index.php?action=agregar-pregunta" class="mt-4">
                            <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                            <div class="mb-3">
                                <label class="form-label">Escribí tu pregunta:</label>
                                <textarea name="mensaje" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-primary">Enviar pregunta</button>
                        </form>
                    <?php else: ?>
                        <p><a href="index.php?action=login">Iniciá sesión</a> para hacer una pregunta.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ⭐ Calificaciones -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">⭐ Calificaciones</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($calificaciones)): ?>
                        <p class="mb-3">Promedio: <strong><?= $promedio ?> / 5</strong></p>
                        <?php foreach ($calificaciones as $c): ?>
                            <div class="mb-3 border-bottom pb-2">
                                <strong><?= $c['autor'] ?>:</strong><br>
                                <?= str_repeat("⭐", $c['puntuacion']) ?><br>
                                <small class="text-muted"><?= htmlspecialchars($c['comentario']) ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Este producto aún no ha sido calificado.</p>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['usuario'])): ?>
                        <form method="POST" action="index.php?action=agregar-calificacion" class="mt-4">
                            <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                            <div class="mb-3">
                                <label class="form-label">Puntuación:</label>
                                <select name="puntuacion" class="form-select w-auto d-inline-block" required>
                                    <option value="1">⭐</option>
                                    <option value="2">⭐⭐</option>
                                    <option value="3">⭐⭐⭐</option>
                                    <option value="4">⭐⭐⭐⭐</option>
                                    <option value="5">⭐⭐⭐⭐⭐</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Comentario:</label>
                                <textarea name="comentario" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-success">Enviar calificación</button>
                        </form>
                    <?php else: ?>
                        <p><a href="index.php?action=login">Iniciá sesión</a> para calificar este producto.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
$contenido = ob_get_clean();
$titulo = "Detalle del Producto";
include 'views/layout.php';
?>