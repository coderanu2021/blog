<?php 
require_once 'BaseManager.php';
require_once 'email_verification.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$fileStatus = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log the incoming request
    error_log("Registration attempt - POST data: " . print_r($_POST, true));
    error_log("Files data: " . print_r($_FILES, true));

    $name     = $_POST['fullname'] ?? '';
    $email    = $_POST['regEmail'] ?? '';
    $phone    = $_POST['mobile'] ?? '';
    $password = $_POST['regPassword'] ?? '';
    $photo    = $_FILES['profilePhoto'] ?? null;

    if (!$name || !$email || !$phone || !$password) {
        error_log("Registration failed - Missing required fields");
        echo json_encode(['status' => 0, 'msg' => 'All fields are required.']);
        exit;
    }

    try {
        // Check if email already exists
        $userTable = new BaseManager('tbl_user');
        $existingUser = $userTable->getOne(['email' => $email]);

        if ($existingUser) {
            error_log("Registration failed - Email already exists: " . $email);
            echo json_encode(['status' => 0, 'msg' => 'Email already exists. Please use a different one.']);
            exit;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Generate verification token
        $verificationToken = bin2hex(random_bytes(32));

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
                error_log("Profile photo uploaded successfully: " . $photoPath);
            } else {
                error_log("File upload failed - Error: " . error_get_last()['message']);
                echo json_encode(['status' => 0, 'msg' => 'File upload failed']);
                exit;
            }
        }

        // Create the new user
        $userData = [
            'name' => $name,
            'email' => $email,
            'phone_no' => $phone,
            'password' => $hashedPassword,
            'profile_photo' => $photoPath,
            'verification_token' => $verificationToken,
            'is_verified' => 0
        ];

        error_log("Attempting to create user with data: " . print_r($userData, true));
        $insertResult = $userTable->create($userData);

        if ($insertResult) {
            error_log("User created successfully");
            // Send verification email
            if (sendVerificationEmail($email, $name, $verificationToken)) {
                error_log("Verification email sent successfully");
                $msg = $fileStatus 
                    ? "Registration successful! Please check your email to verify your account." 
                    : "Registration successful, but photo upload failed. Please check your email to verify your account.";
                echo json_encode(['status' => 1, 'msg' => $msg]);
            } else {
                error_log("Failed to send verification email");
                $msg = "Registration successful, but failed to send verification email. Please contact support.";
                echo json_encode(['status' => 1, 'msg' => $msg]);
            }
        } else {
            error_log("Failed to create user in database");
            echo json_encode(['status' => 0, 'msg' => 'Failed to register user.']);
        }
    } catch (Exception $e) {
        error_log("Registration error: " . $e->getMessage());
        echo json_encode(['status' => 0, 'msg' => 'An error occurred during registration.']);
    }
}
?>
