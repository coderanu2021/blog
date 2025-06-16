<?php
// traits/CrudTrait.php
trait CrudTrait {
    protected $table;
    protected $db;

    public function setTable($tableName) {
        $this->table = $tableName;
        error_log("Table set to: " . $tableName);
    }

    public function create($data) {
        try {
            error_log("Starting create operation for table: " . $this->table);
            error_log("Data to insert: " . print_r($data, true));

            $columns = implode(',', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            
            error_log("SQL Query: " . $sql);
            
            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                error_log("Failed to prepare statement: " . print_r($this->db->errorInfo(), true));
                return false;
            }

            $result = $stmt->execute($data);
            
            if (!$result) {
                error_log("Failed to execute statement: " . print_r($stmt->errorInfo(), true));
                return false;
            }

            error_log("Insert successful. Last Insert ID: " . $this->db->lastInsertId());
            return $result;
        } catch (PDOException $e) {
            error_log("Database Error in create operation: " . $e->getMessage());
            error_log("SQL State: " . $e->getCode());
            error_log("Error Info: " . print_r($this->db->errorInfo(), true));
            return false;
        }
    }

    public function read($conditions = []) {
        $sql = "SELECT * FROM {$this->table}";
        if ($conditions) {
            $clause = implode(' AND ', array_map(fn($k) => "$k = :$k", array_keys($conditions)));
            $sql .= " WHERE $clause";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data, $idColumn = 'id') {
        $fields = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $sql = "UPDATE {$this->table} SET $fields WHERE $idColumn = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id, $idColumn = 'id') {
        $sql = "DELETE FROM {$this->table} WHERE $idColumn = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}

?>