<?php
require_once 'config/database.php';

class Usuario {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function registrar($nombre, $correo, $contrasena, $tipo, $ubicacion) {
        $sql = "INSERT INTO usuarios (nombre, correo, contrasena, tipo, ubicacion) 
                VALUES (:nombre, :correo, :contrasena, :tipo, :ubicacion)";
        $stmt = $this->conn->prepare($sql);
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':contrasena' => $contrasena_hash,
            ':tipo' => $tipo,
            ':ubicacion' => $ubicacion
        ]);
    }

    public function login($correo, $contrasena) {
        $sql = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':correo' => $correo]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            return $usuario;
        }
        return false;
    }

    public function obtenerTodos() {
        $sql = "SELECT id, nombre, correo, tipo, ubicacion, creado_en FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function eliminar($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    
}
?>
