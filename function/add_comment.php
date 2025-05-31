<?php
session_start();
require_once 'BaseManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blog_id = $_POST['blog_id'] ?? '';
    $comment = $_POST['comment'] ?? '';
    
    // Debug logging
    error_log("Comment submission attempt - Blog ID: " . $blog_id . ", Comment: " . $comment);
    error_log("Session user_id: " . ($_SESSION['user_id'] ?? 'not set'));
    
    if (!$blog_id || !$comment) {
        echo json_encode(['status' => 0, 'msg' => 'Blog ID and comment are required.']);
        exit;
    }

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 0, 'msg' => 'Please login to comment.']);
        exit;
    }

    // Create comment
    $commentTable = new BaseManager('tbl_comment');
    $insertResult = $commentTable->create([
        'blog_id' => $blog_id,
        'user_id' => $_SESSION['user_id'],
        'comment' => $comment,
        'status' => '0' // Default status is pending
    ]);

    // Debug logging for insert result
    error_log("Insert result: " . ($insertResult ? 'success' : 'failed'));

    if ($insertResult) {
        echo json_encode(['status' => 1, 'msg' => 'Comment submitted successfully. It will be visible after approval.']);
    } else {
        echo json_encode(['status' => 0, 'msg' => 'Failed to submit comment.']);
    }
}
?> 