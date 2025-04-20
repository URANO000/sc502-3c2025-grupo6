<?php ob_start(); ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h2 class="text-center mb-4">Panel de Administración</h2>
            <p class="text-center">Bienvenido, <strong><?= $_SESSION['usuario']['nombre'] ?></strong> 👤</p>

            <div class="list-group mt-4">
                <a href="index.php?action=ver-usuarios" class="list-group-item list-group-item-action">👥 Ver Usuarios Registrados</a>
                <a href="index.php?action=ver-productos" class="list-group-item list-group-item-action">📦 Ver Todos los Productos</a>
                <a href="index.php?action=estadisticas" class="list-group-item list-group-item-action">📈 Ver Estadísticas del Sistema</a>

                

                <a href="index.php?action=logout" class="list-group-item list-group-item-action text-danger">🚪 Cerrar Sesión</a>
            </div>
        </div>
    </div>
</div>

<?php
$contenido = ob_get_clean();
$titulo = "Dashboard Admin";
include 'views/layout.php';
?>
