<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
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
      <input type="email" class="form-control" id="email" name="email" required />
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" required />
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
  <div class="signup-text">
    Don't have an account? <a href="register.php">Sign up</a>
  </div>
</div>
    </div>
</div>

<!-- ✅ Bootstrap Toast -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
  <div id="toastLogin" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toastLoginBody">Message</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<?php include 'script.php'; ?>
</body>
</html>
