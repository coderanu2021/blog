<?php
require_once 'function/Database.php';

try {
    $db = (new Database())->connect();
    
    // Check if table exists
    $tables = $db->query("SHOW TABLES LIKE 'tbl_blog_category'")->fetchAll();
    echo "Table exists: " . (!empty($tables) ? "Yes" : "No") . "<br>";
    
    if (!empty($tables)) {
        // Get table structure
        $columns = $db->query("DESCRIBE tbl_blog_category")->fetchAll(PDO::FETCH_ASSOC);
        echo "Table structure:<br>";
        print_r($columns);
        echo "<br><br>";
        
        // Get all records
        $records = $db->query("SELECT * FROM tbl_blog_category")->fetchAll(PDO::FETCH_ASSOC);
        echo "All records:<br>";
        print_r($records);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 