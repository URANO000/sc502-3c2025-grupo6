<?php ob_start(); ?>
<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!-- Título + boton volver -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">📈 Estadísticas</h2>
        <p class="text-muted mb-0">Hola, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?> 👋</p>
    </div>
    <?php
$volver = ($_SESSION['usuario']['tipo'] === 'admin') 
    ? 'dashboard-admin' 
    : 'dashboard-emprendedor';
?>
<a href="index.php?action=<?= $volver ?>" class="btn btn-outline-secondary">🏠 Volver al panel</a>

</div>

<!-- Tarjetas de estadísticas -->
<div class="row g-4">
    <div class="col-md-6 col-lg-3">
        <div class="card text-center p-4 shadow-sm">
            <h5 class="text-muted">Productos Publicados</h5>
            <h2><?= $stats['total_productos'] ?></h2>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card text-center p-4 shadow-sm">
            <h5 class="text-muted">Preguntas Recibidas</h5>
            <h2><?= $stats['total_preguntas'] ?></h2>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card text-center p-4 shadow-sm">
            <h5 class="text-muted">Calificaciones</h5>
            <h2><?= $stats['total_calificaciones'] ?></h2>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card text-center p-4 shadow-sm">
            <h5 class="text-muted">Promedio General</h5>
            <h2><?= number_format($stats['promedio_calificacion'], 2) ?> ⭐</h2>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="row mt-5">
    <div class="col-md-6">
        <canvas id="barChart"></canvas>
    </div>
    <div class="col-md-6">
        <canvas id="pieChart" width="380" height="380" style="margin-left: 6rem;"></canvas>
    </div>
</div>

<!-- Script de Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = ['Productos', 'Preguntas', 'Calificaciones'];
    const dataValues = [
        <?= $stats['total_productos'] ?>,
        <?= $stats['total_preguntas'] ?>,
        <?= $stats['total_calificaciones'] ?>
    ];

    // Gráfico de barras
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad',
                data: dataValues,
                backgroundColor: ['#5e9eff', '#6fcf97', '#f2994a']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Totales por Categoría' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Gráfico circular
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dataValues,
                backgroundColor: ['#5e9eff', '#6fcf97', '#f2994a']
            
            }]
        },
        options: {
            responsive: false,
            plugins: {
                title: { display: true, text: 'Distribución General' }
            }
        }
    });
</script>

<?php
$contenido = ob_get_clean();
$titulo = "Estadísticas";
include 'views/layout.php';
?>
