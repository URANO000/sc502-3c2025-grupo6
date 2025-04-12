<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'controllers/UsuarioController.php';
require_once 'controllers/ProductoController.php';
require_once 'controllers/PreguntaController.php';
$preguntaController = new PreguntaController();
require_once 'controllers/CalificacionController.php';
$calificacionController = new CalificacionController();

$action = $_GET['action'] ?? 'login';

// Controladores
$usuarioController = new UsuarioController();
$productoController = new ProductoController();

// Enrutamiento
switch ($action) {
    // Autenticación
    case 'registro':
        $usuarioController->mostrarFormularioRegistro();
        break;
    case 'registrar':
        $usuarioController->registrar();
        break;
    case 'login':
        $usuarioController->mostrarFormularioLogin();
        break;
    case 'loguear':
        $usuarioController->login();
        break;
    case 'logout':
        $usuarioController->logout();
        break;

    // Productos
    case 'mis-productos':
        $productoController->listar();
        break;
    case 'crear-producto':
        $productoController->crear();
        break;
    case 'eliminar-producto':
        $productoController->eliminar();
        break;
    case 'editar-producto':
        $productoController->editar();
        break;

    case 'dashboard-emprendedor':
        if ($_SESSION['usuario']['tipo'] === 'emprendedor') {
            include 'views/productos/dashboard.php';
        } else {
            echo "Acceso denegado.";
        }
        break;
    case 'dashboard-admin':
        include 'views/admin/dashboard-admin.php';
        break;

    case 'ver-usuarios':
        $usuarioController->verUsuarios();
        break;

    case 'eliminar-usuario':
        $usuarioController->eliminarUsuario();
        break;


    case 'ver-productos':
        $productoController->verTodos();
        break;

    case 'eliminar-producto-admin':
        $productoController->eliminarPorAdmin();
        break;

    case 'agregar-pregunta':
        $preguntaController->agregar();
        break;

    case 'ver-preguntas':
        $preguntaController->verRespuestas();
        break;

    case 'responder-pregunta':
        $preguntaController->responder();
        break;
    case 'agregar-calificacion':
        $calificacionController->agregar();
        break;
    case 'ver-producto':
        $productoController->ver();
        break;

    case 'home':
        $productoController->verTienda();
        break;

        case 'estadisticas':
            $productoController->estadisticas();
            break;
        







    default:
        $usuarioController->mostrarFormularioLogin();
        break;
}
?>

