<?php
require_once 'subscriber_manager.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 0, 'msg' => 'Please provide a valid email address.']);
        exit;
    }

    $subscriberManager = new SubscriberManager();
    $result = $subscriberManager->addSubscriber($email);
    
    echo json_encode($result);
    exit;
}

// If not POST request, return error
echo json_encode(['status' => 0, 'msg' => 'Invalid request method.']);
?> 