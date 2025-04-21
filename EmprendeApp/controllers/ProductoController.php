<?php
require_once 'models/Producto.php';
require_once 'models/Calificacion.php';

if (session_status() === PHP_SESSION_NONE) session_start();

class ProductoController {

    public function listar() {
        if (!isset($_SESSION['usuario'])) header("Location: index.php?action=login");

        $producto = new Producto();
        $productos = $producto->obtenerPorUsuario($_SESSION['usuario']['id']);
        include 'views/productos/listar.php';
    }

    public function crear() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $rutaDestino = null;
    
            // Validar imagen
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
    
                
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0755, true);
                }
    
                $nombreImagen = uniqid() . '_' . basename($_FILES['imagen']['name']);
                $rutaDestino = 'uploads/' . $nombreImagen;
    
                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    $_SESSION['mensaje'] = "Error al subir la imagen.";
                    $_SESSION['tipo_mensaje'] = "danger";
                    header("Location: index.php?action=crear-producto");
                    exit;
                }
            } else {
                $_SESSION['mensaje'] = "Por favor seleccioná una imagen válida.";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?action=crear-producto");
                exit;
            }
    
            $data = [
                ':usuario_id' => $_SESSION['usuario']['id'],
                ':categoria_id' => $_POST['categoria_id'],
                ':nombre' => $_POST['nombre'],
                ':descripcion' => $_POST['descripcion'],
                ':precio' => $_POST['precio'],
                ':imagen' => $rutaDestino
            ];
    
            $producto = new Producto();
            $idProducto = $producto->crear($data);
    
            if ($idProducto) {
                $_SESSION['mensaje'] = "✅ Producto publicado con éxito.";
                $_SESSION['tipo_mensaje'] = "success";
                header("Location: index.php?action=mis-productos"); 
                exit;
            } else {
                $_SESSION['mensaje'] = "❌ Error al guardar el producto.";
                $_SESSION['tipo_mensaje'] = "danger";
                header("Location: index.php?action=crear-producto");
                exit;
            }
        } else {
            include 'views/productos/crear.php';
        }
    }
    

    public function eliminar() {
        $producto = new Producto();
        $producto->eliminar($_GET['id'], $_SESSION['usuario']['id']);
        header("Location: index.php?action=mis-productos");
    }

    public function editar() {
        $productoModel = new Producto();
        $usuario_id = $_SESSION['usuario']['id'];
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
    
            // Obtener la imagen actual
            $productoActual = $productoModel->obtenerPorId($id, $usuario_id);
            $rutaImagen = $productoActual['imagen'];
    
            // ¿Se cargó una nueva imagen?
            if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] === 0) {
                if (!is_dir('uploads')) {
                    mkdir('uploads', 0755, true);
                }
    
                $nombreImagen = uniqid() . '_' . basename($_FILES['nueva_imagen']['name']);
                $rutaDestino = 'uploads/' . $nombreImagen;
    
                if (move_uploaded_file($_FILES['nueva_imagen']['tmp_name'], $rutaDestino)) {
                    $rutaImagen = $rutaDestino;
                }
            }
    
            $data = [
                ':nombre' => $_POST['nombre'],
                ':descripcion' => $_POST['descripcion'],
                ':precio' => $_POST['precio'],
                ':imagen' => $rutaImagen,
                ':categoria_id' => $_POST['categoria_id']
            ];
    
            $productoModel->actualizar($id, $usuario_id, $data);
    
            $_SESSION['mensaje'] = "✅ Producto actualizado con éxito.";
            $_SESSION['tipo_mensaje'] = "success";
            header("Location: index.php?action=mis-productos");
            exit;
    
        } else {
            $id = $_GET['id'];
            $producto = $productoModel->obtenerPorId($id, $usuario_id);
    
            if ($producto) {
                include 'views/productos/editar.php';
            } else {
                echo "Producto no encontrado.";
            }
        }
    }
    

    public function ver() {
        if (!isset($_GET['id'])) {
            echo "ID de producto no especificado.";
            return;
        }

        $productoModel = new Producto();
        $producto = $productoModel->obtenerPorId($_GET['id'], null); // null: sin restricción por usuario

        if (!$producto) {
            echo "Producto no encontrado.";
            return;
        }

        require_once 'models/Calificacion.php';
        $calificacion = new Calificacion();
        $calificaciones = $calificacion->obtenerPorProducto($producto['id']);
        $promedio = $calificacion->obtenerPromedio($producto['id']);

        require_once 'models/Pregunta.php';
        $pregunta = new Pregunta();
        $preguntas = $pregunta->obtenerPorProducto($producto['id']);

        include 'views/productos/ver.php';
    }

    public function verTodos() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
            die('Acceso denegado.');
        }

        $producto = new Producto();
        $productos = $producto->obtenerTodos();
        include 'views/admin/ver-productos.php';
    }

    public function eliminarPorAdmin() {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
            die('Acceso denegado.');
        }

        if (isset($_GET['id'])) {
            $producto = new Producto();
            $producto->eliminarPorAdmin($_GET['id']);
        }

        header('Location: index.php?action=ver-productos');
    }

    public function verTienda() {
        $producto = new Producto();
        $productos = $producto->obtenerTodos(); 
        include 'views/home/tienda.php';
    }

    public function estadisticas() {
        if (!isset($_SESSION['usuario'])) {
            die('Acceso denegado.');
        }
    
        $productoModel = new Producto();
    
        // Si es admin,  estos es para mostrar estadísticas globales
        if ($_SESSION['usuario']['tipo'] === 'admin') {
            $stats = $productoModel->obtenerEstadisticasGlobales();
        } else {
            // Si es emprendedor, mostrar sus estadísticas de cada uno de los prductos
            $stats = $productoModel->obtenerEstadisticas($_SESSION['usuario']['id']);
        }
    
        include 'views/productos/estadisticas.php';
    }
    
    



}

