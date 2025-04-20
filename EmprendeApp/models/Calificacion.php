<?php
require_once 'config/database.php';

class Calificacion {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function crear($producto_id, $usuario_id, $puntuacion, $comentario) {

        // esto evita multiples calificaciones por el mismo usuario
        $existe = $this->existe($producto_id, $usuario_id);
        if ($existe) return false;

        $sql = "INSERT INTO calificaciones (producto_id, usuario_id, puntuacion, comentario)
                VALUES (:producto_id, :usuario_id, :puntuacion, :comentario)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':producto_id' => $producto_id,
            ':usuario_id' => $usuario_id,
            ':puntuacion' => $puntuacion,
            ':comentario' => $comentario
        ]);
    }

    public function obtenerPorProducto($producto_id) {
        $sql = "SELECT c.*, u.nombre AS autor
                FROM calificaciones c
                JOIN usuarios u ON c.usuario_id = u.id
                WHERE c.producto_id = :producto_id
                ORDER BY c.fecha DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':producto_id' => $producto_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPromedio($producto_id) {
        $sql = "SELECT AVG(puntuacion) AS promedio FROM calificaciones WHERE producto_id = :producto_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':producto_id' => $producto_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return round($resultado['promedio'], 1);
    }

    private function existe($producto_id, $usuario_id) {
        $sql = "SELECT id FROM calificaciones WHERE producto_id = :producto_id AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':producto_id' => $producto_id, ':usuario_id' => $usuario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
