<?php
require_once 'function/config.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // If user is admin, redirect to admin dashboard
    if ($_SESSION['role'] === 'admin') {
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - Blog</title>
   <?php include 'head.php'; ?>

</head>
<body id="REGISTER-BODY-WRAP">

  <div class="register-card">
    <h3 class="text-center">Create Your Account</h3>
    <form id="registerForm" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="fullname" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="fullname"  name="fullname" value="test"  required>
      </div>
      <div class="mb-3">
        <label for="regEmail" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="regEmail" name="regEmail" value="test@gmail.com"  required>
      </div>
      <div class="mb-3">
        <label for="regPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="regPassword" name="regPassword" value="12345"  required>
      </div>
      <div class="mb-3">
        <label for="mobile" class="form-label">Mobile Number</label>
        <input type="tel" class="form-control" id="mobile" name="mobile" value="123456789" required>
      </div>
      <div class="mb-3">
        <label for="profilePhoto" class="form-label">Profile Photo</label>
        <input type="file" class="form-control" id="profilePhoto"  name="profilePhoto"  accept="image/*">
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <div class="login-link">
      Already have an account? <a href="#">Login</a>
    </div>
  </div>

  <!-- Toast container -->
  <div class="position-fixed top-0 end-0" style="z-index: 1050">
    <div id="toastMessage" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" id="toastBody">Message</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
 <?php  include 'script.php';?>

  
</body>
</html>
