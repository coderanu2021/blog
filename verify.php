<?php
require_once 'function/config.php';
require_once 'function/email_verification.php';

$status = 'error';
$message = 'Invalid verification link.';

if (isset($_GET['token']) && !empty($_GET['token'])) {
    if (verifyEmail($_GET['token'])) {
        $status = 'success';
        $message = 'Your email has been verified successfully. You can now login to your account.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Blog</title>
    <?php include 'head.php'; ?>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="card-title mb-4">Email Verification</h3>
                        <?php if ($status === 'success'): ?>
                            <div class="alert alert-success">
                                <?php echo $message; ?>
                            </div>
                            <a href="login.php" class="btn btn-primary">Go to Login</a>
                        <?php else: ?>
                            <div class="alert alert-danger">
                                <?php echo $message; ?>
                            </div>
                            <a href="register.php" class="btn btn-primary">Back to Register</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'script.php'; ?>
</body>
</html> 