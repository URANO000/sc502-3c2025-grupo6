<?php
require_once 'config/database.php';

class Producto {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function obtenerPorUsuario($usuario_id) {
        $sql = "SELECT p.*, c.nombre AS categoria FROM productos p
                JOIN categorias c ON p.categoria_id = c.id
                WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($data) {
        $sql = "INSERT INTO productos (usuario_id, categoria_id, nombre, descripcion, precio, imagen)
                VALUES (:usuario_id, :categoria_id, :nombre, :descripcion, :precio, :imagen)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
        return $this->conn->lastInsertId(); 
    }
    

    public function eliminar($id, $usuario_id) {
        $sql = "DELETE FROM productos WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id, ':usuario_id' => $usuario_id]);
    }


    public function obtenerPorId($id, $usuario_id = null) {
        if ($usuario_id) {
            $sql = "SELECT p.*, u.nombre AS autor, c.nombre AS categoria
                    FROM productos p
                    JOIN usuarios u ON p.usuario_id = u.id
                    JOIN categorias c ON p.categoria_id = c.id
                    WHERE p.id = :id AND p.usuario_id = :usuario_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id, ':usuario_id' => $usuario_id]);
        } else {
            $sql = "SELECT p.*, u.nombre AS autor, c.nombre AS categoria
                    FROM productos p
                    JOIN usuarios u ON p.usuario_id = u.id
                    JOIN categorias c ON p.categoria_id = c.id
                    WHERE p.id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
        }
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
    public function actualizar($id, $usuario_id, $data) {
        $sql = "UPDATE productos SET 
                nombre = :nombre,
                descripcion = :descripcion,
                precio = :precio,
                imagen = :imagen,
                
                categoria_id = :categoria_id
                WHERE id = :id AND usuario_id = :usuario_id";
    
        $stmt = $this->conn->prepare($sql);
        $data[':id'] = $id;
        $data[':usuario_id'] = $usuario_id;
        return $stmt->execute($data);
    }


    public function obtenerTodos() {
        $sql = "SELECT p.*, u.nombre AS emprendedor, c.nombre AS categoria
                FROM productos p
                JOIN usuarios u ON p.usuario_id = u.id
                JOIN categorias c ON p.categoria_id = c.id
                ORDER BY p.creado_en DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function eliminarPorAdmin($id) {
        // 1. Eliminar calificaciones del producto
        $sql1 = "DELETE FROM calificaciones WHERE producto_id = :id";
        $stmt1 = $this->conn->prepare($sql1);
        $stmt1->execute([':id' => $id]);
    
        // 2. Eliminar preguntas relacionadas
        $sql2 = "DELETE FROM preguntas WHERE producto_id = :id";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->execute([':id' => $id]);
    
        // 3. Eliminar el producto
        $sql3 = "DELETE FROM productos WHERE id = :id";
        $stmt3 = $this->conn->prepare($sql3);
        return $stmt3->execute([':id' => $id]);
    }
    


    public function obtenerEstadisticas($usuario_id) {
        $total = $this->conn->query("SELECT COUNT(*) FROM productos WHERE usuario_id = $usuario_id")->fetchColumn();
    
        $preguntas = $this->conn->query("
            SELECT COUNT(*) FROM preguntas 
            WHERE producto_id IN (SELECT id FROM productos WHERE usuario_id = $usuario_id)
        ")->fetchColumn();
    
        $calificaciones = $this->conn->query("
            SELECT COUNT(*) FROM calificaciones 
            WHERE producto_id IN (SELECT id FROM productos WHERE usuario_id = $usuario_id)
        ")->fetchColumn();
    
        $promedio = $this->conn->query("
            SELECT ROUND(AVG(puntuacion), 2) FROM calificaciones 
            WHERE producto_id IN (SELECT id FROM productos WHERE usuario_id = $usuario_id)
        ")->fetchColumn();
    
        return [
            'total_productos' => $total,
            'total_preguntas' => $preguntas,
            'total_calificaciones' => $calificaciones,
            'promedio_calificacion' => $promedio ?: 0
        ];
    }

    public function obtenerEstadisticasGlobales() {
        $total = $this->conn->query("SELECT COUNT(*) FROM productos")->fetchColumn();
    
        $preguntas = $this->conn->query("SELECT COUNT(*) FROM preguntas")->fetchColumn();
    
        $calificaciones = $this->conn->query("SELECT COUNT(*) FROM calificaciones")->fetchColumn();
    
        $promedio = $this->conn->query("
            SELECT ROUND(AVG(puntuacion), 2) FROM calificaciones
        ")->fetchColumn();
    
        return [
            'total_productos' => $total,
            'total_preguntas' => $preguntas,
            'total_calificaciones' => $calificaciones,
            'promedio_calificacion' => $promedio ?: 0
        ];
    }
    
    
    
    
}
