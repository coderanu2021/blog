<?php
require_once 'config.php';

// Function to handle login
function processLogin($email, $password) {
    global $conn;
    
    // Sanitize inputs
    $email = mysqli_real_escape_string($conn, $email);
    
    // Get user data
    $sql = "SELECT * FROM tbl_user WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            return [
                'status' => 1,
                'msg' => 'Login successful!',
                'role' => $user['role']
            ];
        }
    }
    
    return [
        'status' => 0,
        'msg' => 'Invalid email or password'
    ];
}

// Handle AJAX login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $result = processLogin($email, $password);
    echo json_encode($result);
    exit();
}
?> 