<?php
require_once '../../function/config.php';

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    
    // Get current category image
    $sql = "SELECT image FROM tbl_blog_category WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $category = mysqli_fetch_assoc($result);
    $image = $category['image'];
    
    // Handle new image upload
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../../uploads/categories/";
        if(!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Delete old image if exists
            if($category['image'] && file_exists('../../' . $category['image'])) {
                unlink('../../' . $category['image']);
            }
            $image = 'uploads/categories/' . $new_filename;
        }
    }
    
    $sql = "UPDATE tbl_blog_category SET name = '$name', image = '$image' WHERE id = '$id'";
    
    if(mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating category']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
} 