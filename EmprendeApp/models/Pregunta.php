<?php
require_once 'config/database.php';

class Pregunta {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function crear($producto_id, $usuario_id, $mensaje) {
        $sql = "INSERT INTO preguntas (producto_id, usuario_id, mensaje)
                VALUES (:producto_id, :usuario_id, :mensaje)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':producto_id' => $producto_id,
            ':usuario_id' => $usuario_id,
            ':mensaje' => $mensaje
        ]);
    }

    public function obtenerPorProducto($producto_id) {
        $sql = "SELECT p.*, u.nombre AS autor
                FROM preguntas p
                JOIN usuarios u ON p.usuario_id = u.id
                WHERE p.producto_id = :producto_id
                ORDER BY p.fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':producto_id' => $producto_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function responder($id, $respuesta) {
        $sql = "UPDATE preguntas SET respuesta = :respuesta WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':respuesta' => $respuesta,
            ':id' => $id
        ]);
    }

    public function obtenerPorEmprendedor($usuario_id) {
        $sql = "SELECT p.id, p.mensaje, p.respuesta, p.fecha, u.nombre AS autor, pr.nombre AS producto
                FROM preguntas p
                JOIN productos pr ON p.producto_id = pr.id
                JOIN usuarios u ON p.usuario_id = u.id
                WHERE pr.usuario_id = :usuario_id
                ORDER BY p.fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
