<?php
require_once 'models/Usuario.php';

class UsuarioController {
    public function mostrarFormularioRegistro() {
        require_once 'views/usuarios/registro.php';
    }

    public function mostrarFormularioLogin() {
        require_once 'views/usuarios/login.php';
    }

    public function registrar() {
        $usuario = new Usuario();
        $usuario->registrar(
            $_POST['nombre'],
            $_POST['correo'],
            $_POST['contrasena'],
            $_POST['tipo'],
            $_POST['ubicacion']
        );
        header('Location: index.php?action=login');
    }

    public function login() {
        session_start();
        $usuario = new Usuario();
        $resultado = $usuario->login($_POST['correo'], $_POST['contrasena']);

        if ($resultado) {
            $_SESSION['usuario'] = $resultado;

            // Redirección según tipo de usuario
            switch ($resultado['tipo']) {
                case 'emprendedor':
                    header('Location: index.php?action=dashboard-emprendedor');
                    break;
                case 'admin':
                    header('Location: index.php?action=dashboard-admin');
                    break;
                case 'consumidor':
                    header('Location: index.php?action=home'); 
                    break;
                default:
                    header('Location: index.php');
                    break;
            }
        } else {
            echo "<p style='color:red;'>Credenciales inválidas.</p>";
            require_once 'views/usuarios/login.php';
        }
    }

    public function verUsuarios() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
            die('Acceso denegado.');
        }
    
        $usuario = new Usuario();
        $usuarios = $usuario->obtenerTodos();
        include 'views/admin/ver-usuarios.php';
    }
    
    public function eliminarUsuario() {
        session_start();
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
            die('Acceso denegado.');
        }
    
        if (isset($_GET['id'])) {
            $usuario = new Usuario();
            $usuario->eliminar($_GET['id']);
        }
    
        header('Location: index.php?action=ver-usuarios');
    }
    

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?action=login');
    }
}

