<?php 
session_start();
require_once 'BaseManager.php';

$fileStatus = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title     = $_POST['title'] ?? '';
    $metaTitle    = $_POST['metaTitle'] ?? '';
    $metaDesc    = $_POST['metaDesc'] ?? '';
    $description    = $_POST['description'] ?? '';
    $category_id    = $_POST['category_id'] ?? '';
    $photo    = $_FILES['image'] ?? null;


    if (!$title || !$metaTitle || !$metaDesc || !$regPassword || !description || !category_id || !photo) {
        echo json_encode(['status' => 0, 'msg' => 'All fields are required.']);
        exit;
    }

  

    // Upload profile photo
    $photoPath = null;
    if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/blog/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = uniqid() . '_' . basename($photo['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($photo['tmp_name'], $targetPath)) {
            $photoPath = $targetPath;
            $fileStatus = true;
        } else {
            echo json_encode(['status' => 0, 'msg' => 'File upload failed']);
            exit;
        }
    }

    // Create the new user
    $insertResult = $userTable->create([
        'user_id'=>$_SESSION['user_id'],
        'title'          => $title,
        'meta_title'         => $metaTitle,
        'short_desc'      => $metaDesc,
        'long_desc'      => $description,
        'category_id' => $category_id,
        'image' => $photoPath


    ]);

    if ($insertResult) {
        $msg = $fileStatus 
            ? "User registered successfully!" 
            : "User registered, but photo upload failed.";
        echo json_encode(['status' => 1, 'msg' => $msg]);
    } else {
        echo json_encode(['status' => 0, 'msg' => 'Failed to register user.']);
    }
}
?>
