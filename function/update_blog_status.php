<?php
session_start();
require_once 'BaseManager.php';
require_once 'send_email.php';
require_once 'subscriber_manager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blog_id = $_POST['blog_id'] ?? '';
    $new_status = $_POST['status'] ?? '';
    
    if (!$blog_id || !$new_status) {
        echo json_encode(['status' => 0, 'msg' => 'Blog ID and status are required.']);
        exit;
    }

    // Get blog details
    $blogTable = new BaseManager('tbl_blog');
    $blog = $blogTable->getOne(['id' => $blog_id]);
    
    if (!$blog) {
        echo json_encode(['status' => 0, 'msg' => 'Blog not found.']);
        exit;
    }

    // Get user details
    $userTable = new BaseManager('tbl_user');
    $user = $userTable->getOne(['id' => $blog['user_id']]);
    
    if (!$user) {
        echo json_encode(['status' => 0, 'msg' => 'User not found.']);
        exit;
    }

    // Update blog status
    $updateResult = $blogTable->update($blog_id, ['status' => $new_status]);

    if ($updateResult) {
        // Prepare email content
        $statusText = '';
        switch ($new_status) {
            case '0':
                $statusText = 'Pending';
                break;
            case '1':
                $statusText = 'Approved';
                break;
            case '2':
                $statusText = 'Rejected';
                break;
        }

        $subject = "Your Blog Post Status Has Been Updated";
        $body = "
            <h2>Blog Post Status Update</h2>
            <p>Dear {$user['name']},</p>
            <p>Your blog post titled <strong>{$blog['title']}</strong> has been {$statusText}.</p>
            <p>Thank you for contributing to our blog!</p>
            <p>Best regards,<br>Blog Admin Team</p>
        ";

        // Send email notification to author
        $emailSent = sendEmail($user['email'], $subject, $body);

        // If blog is approved, notify subscribers
        if ($new_status == '1') {
            $subscriberManager = new SubscriberManager();
            $subscriberManager->notifySubscribers($blog);
        }

        $response = [
            'status' => 1,
            'msg' => 'Blog status updated successfully' . ($emailSent ? ' and notification sent.' : ' but email notification failed.')
        ];
    } else {
        $response = ['status' => 0, 'msg' => 'Failed to update blog status.'];
    }

    echo json_encode($response);
}
?> 