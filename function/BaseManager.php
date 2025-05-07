<?php 
// BaseManager.php
require_once 'Database.php';
require_once 'CrudTrait.php';

class BaseManager {
    use CrudTrait;

    public function __construct($tableName) {
        $this->db = (new Database())->connect();
        $this->setTable($tableName);
    }

    public function getOne(array $conditions)
    {
        $sql = "SELECT * FROM {$this->table} WHERE ";
        $fields = [];
        $values = [];
    
        foreach ($conditions as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
    
        $sql .= implode(' AND ', $fields);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllRecord() {
    
        // Validate or sanitize the table name
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $this->table); // Basic sanitization
    
        // Build the query string safely
        $query = $this->db->prepare("SELECT * FROM `$table`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

}


?>