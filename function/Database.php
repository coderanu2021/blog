<?php 
class Database {
    private $host = "localhost";
    private $db = "blog_db";
    private $user = "root";
    private $pass = "";
    public $conn;

    public function connect() {
        if ($this->conn === null) {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->conn;
    }
}


?>