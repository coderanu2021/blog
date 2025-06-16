<?php 
class Database {
    private $host = "localhost";
    private $db = "blog_db";
    private $user = "root";
    private $pass = "";
    public $conn;

    public function connect() {
        try {
            if ($this->conn === null) {
                error_log("Attempting to connect to database: {$this->db} on {$this->host}");
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                error_log("Database connection successful");
            }
            return $this->conn;
        } catch(PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            error_log("Connection Details - Host: {$this->host}, Database: {$this->db}, User: {$this->user}");
            throw $e;
        }
    }
}


?>