<?php
require_once 'config.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Table Check</h2>";

// Check if table exists
$table_name = 'tbl_blog_category';
$result = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");

if (mysqli_num_rows($result) > 0) {
    echo "<p style='color: green;'>✓ Table '$table_name' exists</p>";
    
    // Get table structure
    $result = mysqli_query($conn, "DESCRIBE $table_name");
    echo "<h3>Table Structure:</h3>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Get record count
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM $table_name");
    $row = mysqli_fetch_assoc($result);
    echo "<p>Number of records: " . $row['count'] . "</p>";
    
    // Show sample data
    $result = mysqli_query($conn, "SELECT * FROM $table_name LIMIT 5");
    echo "<h3>Sample Data:</h3>";
    echo "<table border='1' cellpadding='5'>";
    if ($row = mysqli_fetch_assoc($result)) {
        // Print headers
        echo "<tr>";
        foreach ($row as $key => $value) {
            echo "<th>" . $key . "</th>";
        }
        echo "</tr>";
        
        // Reset result pointer
        mysqli_data_seek($result, 0);
        
        // Print data
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>✗ Table '$table_name' does not exist</p>";
    
    // Create table
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    )";
    
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color: green;'>✓ Table created successfully</p>";
    } else {
        echo "<p style='color: red;'>✗ Error creating table: " . mysqli_error($conn) . "</p>";
    }
}
?> 