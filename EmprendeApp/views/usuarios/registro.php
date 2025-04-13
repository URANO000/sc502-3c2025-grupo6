<?php ob_start(); ?>
<?php $bodyClass = 'login-background'; ?>

<div class="login-wrapper login-background">
    <div class="col-md-5">
        <div class="card p-5 shadow-sm">
            <h3 class="text-center mb-4">📝 Registro de Usuario</h3>

            <form method="POST" action="index.php?action=registrar">
                <div class="mb-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
                </div>
                <div class="mb-3">
                    <select name="tipo" class="form-select" required>
                        <option value="emprendedor">Emprendedor</option>
                        <option value="consumidor">Consumidor</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input type="text" name="ubicacion" class="form-control" placeholder="Ubicación (opcional)">
                </div>
                <button type="submit" class="btn btn-acento w-100">✅ Registrarse</button>
            </form>

            <p class="text-center mt-3">
                ¿Ya tenés cuenta? <a href="index.php?action=login">Iniciar sesión</a>
            </p>
        </div>
    </div>
</div>

<?php
$contenido = ob_get_clean();
$titulo = "Registro";
include 'views/layout.php';
?>




