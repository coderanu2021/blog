<?php
require_once '../../function/config.php';

header('Content-Type: application/json');

if(isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    // Get post image before deleting
    $sql = "SELECT image FROM tbl_blog WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);
    
    // Delete post
    $sql = "DELETE FROM tbl_blog WHERE id = '$id'";
    if(mysqli_query($conn, $sql)) {
        // Delete post image if exists
        if($post && $post['image'] && file_exists('../../' . $post['image'])) {
            unlink('../../' . $post['image']);
        }
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting post']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
} 