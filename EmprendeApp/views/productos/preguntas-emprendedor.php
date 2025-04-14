<?php ob_start(); ?>
<head><title>Preguntas de mis productos</title></head>
<body>
    <h2 class="mb-0">Preguntas Recibidas</h2>
    <a href="index.php?action=dashboard-emprendedor">← Volver al panel</a>

    <?php foreach ($preguntas as $p): ?>
        <div style="border:1px solid #ccc; margin:10px; padding:10px;" class="card-header bg-light">
            <strong><?= $p['autor'] ?> preguntó sobre <?= $p['producto'] ?>:</strong><br>
            <p><?= htmlspecialchars($p['mensaje']) ?></p>
            <?php if ($p['respuesta']): ?>
                <p><em>Respuesta: <?= htmlspecialchars($p['respuesta']) ?></em></p>
            <?php else: ?>
                <form method="POST" action="index.php?action=responder-pregunta">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <textarea name="respuesta" placeholder="Responder..." required></textarea><br>
                    <button type="submit" class="btn btn-outline-success">Responder</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>

<?php
$contenido = ob_get_clean();
$titulo = "Detalle del Producto";
include 'views/layout.php';
?>