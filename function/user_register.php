<?php 
require_once 'BaseManager.php';

$fileStatus = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['fullname'] ?? '';
    $email    = $_POST['regEmail'] ?? '';
    $phone    = $_POST['mobile'] ?? '';
    $password = $_POST['regPassword'] ?? '';
    $photo    = $_FILES['profilePhoto'] ?? null;

    if (!$name || !$email || !$phone || !$password) {
        echo json_encode(['status' => 0, 'msg' => 'All fields are required.']);
        exit;
    }

    // Check if email already exists
    $userTable = new BaseManager('tbl_user');
    $existingUser = $userTable->getOne(['email' => $email]);

    if ($existingUser) {
        echo json_encode(['status' => 0, 'msg' => 'Email already exists. Please use a different one.']);
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Upload profile photo
    $photoPath = null;
    if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
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
        'name'          => $name,
        'email'         => $email,
        'phone_no'      => $phone,
        'password'      => $hashedPassword,
        'profile_photo' => $photoPath
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
