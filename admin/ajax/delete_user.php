<?php
require_once '../../function/config.php';

header('Content-Type: application/json');

if(isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    // Delete user
    $sql = "DELETE FROM tbl_user WHERE id = '$id'";
    if(mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting user']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
} 