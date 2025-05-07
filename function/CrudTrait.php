<?php
// traits/CrudTrait.php
trait CrudTrait {
    protected $table;
    protected $db;

    public function setTable($tableName) {
        $this->table = $tableName;
    }

    public function create($data) {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
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