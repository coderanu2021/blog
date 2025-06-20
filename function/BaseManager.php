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
        
        // Debug information
        error_log("SQL Query: " . $sql);
        error_log("Parameters: " . print_r($values, true));
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Debug information
        error_log("Query Result: " . print_r($result, true));
        
        return $result;
    }

    public function getRecordById($id) {
        // Debug information
        error_log("Fetching record with ID: " . $id . " from table: " . $this->table);
        
        $result = $this->getOne(['id' => $id]);
        
        // Debug information
        error_log("Query result: " . print_r($result, true));
        
        return $result;
    }

    public function getAllRecord() {
        // Validate or sanitize the table name
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $this->table); // Basic sanitization
    
        // Build the query string safely
        $query = $this->db->prepare("SELECT * FROM `$table`");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        // Debug information
        error_log("getAllRecord for table {$table}: " . print_r($result, true));
        
        return $result;
    }

    public function getRecordsByField($field, $value, $orderBy = null) {
        // Validate or sanitize the table name and field name
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $this->table);
        $field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        
        // Build the query string safely
        $sql = "SELECT * FROM `$table` WHERE `$field` = ?";
        
        // Add ORDER BY clause if provided
        if ($orderBy) {
            $orderBy = preg_replace('/[^a-zA-Z0-9_,\s]/', '', $orderBy);
            $sql .= " ORDER BY $orderBy";
        }
        
        $query = $this->db->prepare($sql);
        $query->execute([$value]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        // Debug information
        error_log("getRecordsByField for table {$table}, field {$field}: " . print_r($result, true));
        
        return $result;
    }

    // Alias for create method
    public function insert($data) {
        return $this->create($data);
    }
}


?>