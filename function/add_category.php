<?php
require_once 'BaseManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $photo = $_FILES['image'] ?? null; // Use $_FILES for file uploads

    // Validate required fields
    if (empty($title) || empty($photo)) {
        echo json_encode(['status' => 0, 'msg' => 'All fields are required.']);
        exit;
    }

    $categoryTable = new BaseManager('tbl_blog_category');

    // Upload profile photo
    $photoPath = null;
    if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../Uploads/category/';
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
    } else {
        echo json_encode(['status' => 0, 'msg' => 'Invalid file or upload error']);
        exit;
    }

    // Create the new category
    $insertResult = $categoryTable->create([
        'name' => $title,
        'image' => $photoPath,
    ]);

    if ($insertResult) {
        echo json_encode(['status' => 1, 'msg' => 'Category added successfully!']);
    } else {
        echo json_encode(['status' => 0, 'msg' => 'Failed to add category']);
    }
    exit;
}
?>