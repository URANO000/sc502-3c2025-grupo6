<?php
require_once 'models/Pregunta.php';
if (session_status() === PHP_SESSION_NONE) session_start();

class PreguntaController {
    public function agregar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $pregunta = new Pregunta();
            $pregunta->crear($_POST['producto_id'], $_SESSION['usuario']['id'], $_POST['mensaje']);
            header("Location: index.php?action=ver-producto&id=" . $_POST['producto_id']);
        }
    }

    public function verRespuestas() {
        if ($_SESSION['usuario']['tipo'] !== 'emprendedor') die('Acceso denegado.');
        $pregunta = new Pregunta();
        $preguntas = $pregunta->obtenerPorEmprendedor($_SESSION['usuario']['id']);
        include 'views/productos/preguntas-emprendedor.php';
    }

    public function responder() {
        if ($_SESSION['usuario']['tipo'] !== 'emprendedor') die('Acceso denegado.');
        $pregunta = new Pregunta();
        $pregunta->responder($_POST['id'], $_POST['respuesta']);
        header("Location: index.php?action=ver-preguntas");
    }
}
