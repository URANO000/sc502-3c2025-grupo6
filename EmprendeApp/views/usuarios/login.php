<?php ob_start(); ?>
<?php $bodyClass = 'login-background'; ?>


<div class="login-wrapper login-background">
    <div class="col-md-5">
        <div class="card p-5 shadow-sm">

            <div class="text-center mb-4">
                <h2 class="mb-1">👋 ¡Bienvenido!</h2>
                <p class="text-muted">Ingresa con tus credenciales para continuar</p>
            </div>

            <form method="POST" action="index.php?action=loguear">
                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="correo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="contrasena" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-acento w-100">➡️ Iniciar sesión</button>
            </form>

            <p class="text-center mt-3">
                ¿No tenés cuenta? <a href="index.php?action=registro">Registrate aquí</a>
            </p>

        </div>
    </div>
</div>

<?php
$contenido = ob_get_clean();
$titulo = "Iniciar Sesión";
include 'views/layout.php';
?>





