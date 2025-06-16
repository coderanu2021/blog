<?php
require_once 'config.php';
require_once 'BaseManager.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendVerificationEmail($email, $name, $token) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'youremail@gmail.com';
        $mail->Password = 'your app password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Enable debug output
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function($str, $level) {
            error_log("PHPMailer Debug: $str");
        };

        // Recipients
        $mail->setFrom('Recipients@gmail.com', 'Your Blog Name');
        $mail->addAddress($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Our Blog - Verify Your Email';
        
        $verificationLink = "http://" . $_SERVER['HTTP_HOST'] . "/blog/verify.php?token=" . $token;
        
        // Modern HTML Email Template
        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Email Verification</title>
        </head>
        <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4;">
                <tr>
                    <td style="padding: 20px 0; text-align: center;">
                        <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <!-- Header -->
                            <tr>
                                <td style="padding: 40px 30px; background: linear-gradient(135deg, #6366f1, #4f46e5); border-radius: 8px 8px 0 0;">
                                    <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 600;">Welcome to Our Blog!</h1>
                                </td>
                            </tr>
                            
                            <!-- Content -->
                            <tr>
                                <td style="padding: 40px 30px;">
                                    <p style="margin: 0 0 20px; color: #333333; font-size: 16px; line-height: 1.5;">Dear ' . htmlspecialchars($name) . ',</p>
                                    
                                    <p style="margin: 0 0 20px; color: #333333; font-size: 16px; line-height: 1.5;">Thank you for joining our community! We\'re excited to have you on board.</p>
                                    
                                    <p style="margin: 0 0 30px; color: #333333; font-size: 16px; line-height: 1.5;">To get started, please verify your email address by clicking the button below:</p>
                                    
                                    <div style="text-align: center; margin: 30px 0;">
                                        <a href="' . $verificationLink . '" style="display: inline-block; padding: 14px 28px; background-color: #4f46e5; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 16px;">Verify Email Address</a>
                                    </div>
                                    
                                    <p style="margin: 0 0 20px; color: #666666; font-size: 14px; line-height: 1.5;">Or copy and paste this link into your browser:</p>
                                    <p style="margin: 0 0 30px; color: #666666; font-size: 14px; line-height: 1.5; word-break: break-all;">' . $verificationLink . '</p>
                                    
                                    <p style="margin: 0 0 20px; color: #333333; font-size: 16px; line-height: 1.5;">This verification link will expire in 24 hours.</p>
                                    
                                    <p style="margin: 0; color: #666666; font-size: 14px; line-height: 1.5;">If you did not create an account, please ignore this email.</p>
                                </td>
                            </tr>
                            
                            <!-- Footer -->
                            <tr>
                                <td style="padding: 30px; background-color: #f8f9fa; border-radius: 0 0 8px 8px; text-align: center;">
                                    <p style="margin: 0; color: #666666; font-size: 14px;">© ' . date('Y') . ' Your Blog Name. All rights reserved.</p>
                                    <p style="margin: 10px 0 0; color: #666666; font-size: 14px;">123 Blog Street, City, Country</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>';

        // Plain text version for email clients that don't support HTML
        $mail->AltBody = "Dear " . $name . ",\n\n" .
            "Thank you for registering with our blog. Please verify your email address by clicking the link below:\n\n" .
            $verificationLink . "\n\n" .
            "If you did not create an account, please ignore this email.\n\n" .
            "Best regards,\n" .
            "Your Blog Team";

        $mail->send();
        error_log("Verification email sent successfully to: " . $email);
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        error_log("Error details: " . $e->getMessage());
        return false;
    }
}

function verifyEmail($token) {
    $userTable = new BaseManager('tbl_user');
    $user = $userTable->getOne(['verification_token' => $token]);
    
    if ($user) {
        $updateResult = $userTable->update($user['id'], [
            'is_verified' => 1,
            'verification_token' => null
        ]);
        
        return $updateResult;
    }
    
    return false;
}
?> 