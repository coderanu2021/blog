<?php
require_once 'config.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize response array
$response = [
    'total_users' => 0,
    'total_blogs' => 0,
    'total_categories' => 0,
    'pending_blogs' => 0,
    'rejected_blogs' => 0,
    'total_comments' => 0,
    'debug' => [] // Add debug information
];

try {
    // Check database connection
    if (!$conn) {
        throw new Exception("Database connection failed: " . mysqli_connect_error());
    }

    // Get list of all tables
    $tables_query = mysqli_query($conn, "SHOW TABLES");
    $tables = [];
    while ($row = mysqli_fetch_row($tables_query)) {
        $tables[] = $row[0];
    }
    $response['debug']['tables'] = $tables;

    // Check if required tables exist
    $required_tables = ['tbl_user', 'tbl_blog', 'tbl_blog_category', 'tbl_comments'];
    foreach ($required_tables as $table) {
        if (!in_array($table, $tables)) {
            $response['debug']['missing_tables'][] = $table;
        }
    }

    // Get total users
    if (in_array('tbl_user', $tables)) {
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_user");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $response['total_users'] = $row ? (int)$row['count'] : 0;
        } else {
            $response['debug']['errors'][] = "Error counting users: " . mysqli_error($conn);
        }
    }

    // Get total blogs
    if (in_array('tbl_blog', $tables)) {
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_blog");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $response['total_blogs'] = $row ? (int)$row['count'] : 0;
        } else {
            $response['debug']['errors'][] = "Error counting blogs: " . mysqli_error($conn);
        }
    }

    // Get total categories
    if (in_array('tbl_blog_category', $tables)) {
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_blog_category");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $response['total_categories'] = $row ? (int)$row['count'] : 0;
        } else {
            $response['debug']['errors'][] = "Error counting categories: " . mysqli_error($conn);
        }
    }

    // Get pending blogs
    if (in_array('tbl_blog', $tables)) {
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_blog WHERE status = 0");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $response['pending_blogs'] = $row ? (int)$row['count'] : 0;
        } else {
            $response['debug']['errors'][] = "Error counting pending blogs: " . mysqli_error($conn);
        }
    }

    // Get rejected blogs
    if (in_array('tbl_blog', $tables)) {
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_blog WHERE status = 2");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $response['rejected_blogs'] = $row ? (int)$row['count'] : 0;
        } else {
            $response['debug']['errors'][] = "Error counting rejected blogs: " . mysqli_error($conn);
        }
    }

    // Get total comments
    if (in_array('tbl_comments', $tables)) {
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_comments");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $response['total_comments'] = $row ? (int)$row['count'] : 0;
        } else {
            $response['debug']['errors'][] = "Error counting comments: " . mysqli_error($conn);
        }
    }

} catch (Exception $e) {
    $response['debug']['error'] = $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response); 