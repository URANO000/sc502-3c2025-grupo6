<?php
class Database {
    private $host = "localhost";
    private $port = 3307; //es porque no me sirve la conn con MySQL
    private $db_name = "emprende_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function conectar() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host .";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username, $this->password
            );
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
