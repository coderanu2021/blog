<?php
session_start();

require_once 'function/config.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {



    // If user is admin, redirect to admin dashboard
    if (isset($_SESSION['role']) && !empty($_SESSION['role'])) {
        header('Location: admin/dashboard.php');
    } else {
        // If regular user, redirect to home page
        header('Location: index.php');
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Blog</title>
    <?php include 'head.php'; ?>
</head>
<body>
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="login-card">
                <h3 class="text-center">Welcome Back</h3>
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <div class="signup-text">
                    Don't have an account? <a href="register.php">Sign up</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Toast -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
        <div id="toastLogin" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastLoginBody">Message</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <?php include 'script.php'; ?>
    
    <script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: 'function/login_process.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const result = JSON.parse(response);
                    const toast = new bootstrap.Toast(document.getElementById("toastLogin"));
                    
                    if (result.status === 1) {
                        $('#toastLogin').removeClass('bg-danger').addClass('bg-success');
                        $('#toastLoginBody').text(result.msg);
                        toast.show();
                        
                        // Redirect based on role
                        if (result.role === 'admin') {
                            window.location.href = 'admin/dashboard.php';
                        } else {
                            window.location.href = 'index.php';
                        }
                    } else {
                        $('#toastLogin').removeClass('bg-success').addClass('bg-danger');
                        $('#toastLoginBody').text(result.msg);
                        toast.show();
                    }
                }
            });
        });
    });
    </script>
</body>
</html>
