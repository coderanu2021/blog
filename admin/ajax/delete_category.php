<?php
require_once '../../function/config.php';

header('Content-Type: application/json');

if(isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    // Get category image before deleting
    $sql = "SELECT image FROM tbl_blog_category WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $category = mysqli_fetch_assoc($result);
    
    // Delete category
    $sql = "DELETE FROM tbl_blog_category WHERE id = '$id'";
    if(mysqli_query($conn, $sql)) {
        // Delete category image if exists
        if($category && $category['image'] && file_exists('../../' . $category['image'])) {
            unlink('../../' . $category['image']);
        }
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting category']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
} 