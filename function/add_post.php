<?php 
session_start();
require_once 'BaseManager.php';
require_once 'config.php';
require_once 'subscriber_manager.php';

$fileStatus = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title     = $_POST['title'] ?? '';
    $metaTitle    = $_POST['metaTitle'] ?? '';
    $metaDesc    = $_POST['metaDesc'] ?? '';
    $description    = $_POST['description'] ?? '';
    $category_id    = $_POST['category_id'] ?? '';
    $photo    = $_FILES['image'] ?? null;

    if (!$title || !$metaTitle || !$metaDesc || !$description || !$category_id || !$photo) {
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

    // Create the new blog post
    $blogTable = new BaseManager('tbl_blog');
    $insertResult = $blogTable->create([
        'user_id' => $_SESSION['user_id'],
        'title' => $title,
        'meta_title' => $metaTitle,
        'short_desc' => $metaDesc,
        'long_desc' => $description,
        'category_id' => $category_id,
        'image' => $photoPath,
        'status' => BLOG_STATUS_PENDING // Set initial status as pending
    ]);

    if ($insertResult) {
        // Get the newly created blog post
        $newBlog = $blogTable->getOne(['id' => $insertResult]);
        
        // Notify subscribers if blog is approved
        if ($newBlog['status'] == BLOG_STATUS_APPROVED) {
            $subscriberManager = new SubscriberManager();
            $subscriberManager->notifySubscribers($newBlog);
        }

        $msg = $fileStatus 
            ? "Blog post submitted successfully! It will be reviewed by an admin." 
            : "Blog post submitted, but photo upload failed.";
        echo json_encode(['status' => 1, 'msg' => $msg]);
    } else {
        echo json_encode(['status' => 0, 'msg' => 'Failed to add blog post.']);
    }
}
?>
