<?php
require_once 'config.php';

// Read the SQL file
$sql = file_get_contents(__DIR__ . '/../sql/comments.sql');

// Execute the SQL
if (mysqli_multi_query($conn, $sql)) {
    echo "Comments table created successfully!";
} else {
    echo "Error creating comments table: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?> 