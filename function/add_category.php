<?php 
require_once 'BaseManager.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title     = $_POST['title'] ?? '';
    $photo    = $_POST['image'] ?? '';
    

    if (!$title || !$photo || !$phone || !$password) {
        echo json_encode(['status' => 0, 'msg' => 'All fields are required.']);
        exit;
    }

    $categoryTable = new BaseManager('tbl_blog_category');

    // Upload profile photo
    $photoPath = null;
    if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/category/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = uniqid() . '_' . basename($photo['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($photo['tmp_name'], $targetPath)) {
            $photoPath = $targetPath;
        } else {
            echo json_encode(['status' => 0, 'msg' => 'File upload failed']);
            exit;
        }
    }
    // Create the new user
    $insertResult = $userTable->create([
        'title'          => $name,
        'image'         => $title,
    
    ]);


        echo json_encode(['status' => 1, 'msg' => "User registered successfully!"]);
   
}
?>
