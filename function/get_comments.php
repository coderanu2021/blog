<?php
session_start();
require_once 'BaseManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $blog_id = $_GET['blog_id'] ?? '';
    
    if (!$blog_id) {
        echo json_encode(['status' => 0, 'msg' => 'Blog ID is required.']);
        exit;
    }

    // Get comments
    $commentTable = new BaseManager('tbl_comments');
    $userTable = new BaseManager('tbl_user');
    
    $comments = $commentTable->read(['blog_id' => $blog_id, 'status' => '1']); // Only get approved comments
    
    // Add user information to each comment
    foreach ($comments as &$comment) {
        $user = $userTable->getOne(['id' => $comment['user_id']]);
        $comment['user_name'] = $user ? $user['name'] : 'Unknown';
        $comment['user_photo'] = $user ? $user['profile_photo'] : null;
    }

    echo json_encode(['status' => 1, 'comments' => $comments]);
}
?> 