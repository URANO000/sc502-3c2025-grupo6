<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?? 'Mi App' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            background: #f3f6f9 url('views/assets/img/fondo-corporativo.png') no-repeat center center fixed;
            background-size: cover;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            background-color: white;
        }

        .btn-acento {
            background-color: #5e9eff;
            color: white;
        }

        .btn-acento:hover {
            background-color: #4a8ad4;
        }
    </style>
</head>
<body>

    <div class="container my-5">
        <!-- ✅ ALERTAS -->
        <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['mensaje'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
            <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
        <?php endif; ?>

        <!-- ✅ CONTENIDO DE LA VISTA -->
        <?= $contenido ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


