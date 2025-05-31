<?php
// traits/CrudTrait.php
trait CrudTrait {
    protected $table;
    protected $db;

    public function setTable($tableName) {
        $this->table = $tableName;
    }

    public function create($data) {
        try {
            $columns = implode(',', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            
            // Debug logging
            error_log("SQL Query: " . $sql);
            error_log("Data to insert: " . print_r($data, true));
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute($data);
            
            // Debug logging
            error_log("Insert result: " . ($result ? 'success' : 'failed'));
            if (!$result) {
                error_log("PDO Error Info: " . print_r($stmt->errorInfo(), true));
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
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