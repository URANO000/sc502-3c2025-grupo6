<?php
require_once 'models/Calificacion.php';
if (session_status() === PHP_SESSION_NONE) session_start();

class CalificacionController {
    public function agregar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $calificacion = new Calificacion();
            $exito = $calificacion->crear(
                $_POST['producto_id'],
                $_SESSION['usuario']['id'],
                $_POST['puntuacion'],
                $_POST['comentario']
            );

            if (!$exito) {
                $_SESSION['error'] = "Ya calificaste este producto.";
            }

            header("Location: index.php?action=ver-producto&id=" . $_POST['producto_id']);
        }
    }
}
