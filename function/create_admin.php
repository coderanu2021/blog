<?php
require_once 'config.php';

// Check if admin user exists
$sql = "SELECT * FROM tbl_user WHERE email = 'admin@example.com' AND role = 'admin'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 0) {
    // Create admin user
    $name = 'Admin';
    $email = 'admin@example.com';
    $password = password_hash('admin123', PASSWORD_BCRYPT);
    $role = 'admin';
    
    $sql = "INSERT INTO tbl_user (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $password, $role);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Admin user created successfully!<br>";
        echo "Email: admin@example.com<br>";
        echo "Password: admin123<br>";
    } else {
        echo "Error creating admin user: " . mysqli_error($conn);
    }
} else {
    echo "Admin user already exists!";
}
?> 