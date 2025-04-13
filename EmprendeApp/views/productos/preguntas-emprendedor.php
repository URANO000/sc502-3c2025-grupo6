<!DOCTYPE html>
<html>
<head><title>Preguntas de mis productos</title></head>
<body>
    <h2>Preguntas Recibidas</h2>
    <a href="index.php?action=dashboard-emprendedor">← Volver al panel</a>

    <?php foreach ($preguntas as $p): ?>
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <strong><?= $p['autor'] ?> preguntó sobre <?= $p['producto'] ?>:</strong><br>
            <p><?= htmlspecialchars($p['mensaje']) ?></p>
            <?php if ($p['respuesta']): ?>
                <p><em>Respuesta: <?= htmlspecialchars($p['respuesta']) ?></em></p>
            <?php else: ?>
                <form method="POST" action="index.php?action=responder-pregunta">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <textarea name="respuesta" placeholder="Responder..." required></textarea><br>
                    <button type="submit">Responder</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
