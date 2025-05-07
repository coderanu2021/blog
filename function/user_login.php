<?php
session_start();
require_once 'BaseManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 0, 'msg' => 'Email and password are required.']);
        exit;
    }

    // Get user
    $userTable = new BaseManager('tbl_user');
    $user = $userTable->getOne(['email' => $email]);

    if (!$user) {
        echo json_encode(['status' => 0, 'msg' => 'User not found.']);
        exit;
    }

    if (!password_verify($password, $user['password'])) {
        echo json_encode(['status' => 0, 'msg' => 'Incorrect password.']);
        exit;
    }

    // Save login to session
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['email']     = $user['email'];

    echo json_encode(['status' => 1, 'msg' => 'Login successful!']);
}
?>
