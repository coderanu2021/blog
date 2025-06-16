<?php
require_once 'BaseManager.php';
require_once 'send_email.php';

class SubscriberManager extends BaseManager {
    public function __construct() {
        parent::__construct('tbl_subscribers');
    }

    public function addSubscriber($email) {
        // Check if email already exists
        $existing = $this->getOne(['email' => $email]);
        if ($existing) {
            return ['status' => 0, 'msg' => 'Email already subscribed'];
        }

        // Add new subscriber
        $result = $this->insert([
            'email' => $email,
            'status' => 1
        ]);

        if ($result) {
            // Send welcome email
            $subject = "Welcome to Our Blog Newsletter!";
            $body = "
                <h2>Welcome to Our Blog!</h2>
                <p>Thank you for subscribing to our newsletter. You'll now receive updates about our latest blog posts.</p>
                <p>Best regards,<br>Blog Team</p>
            ";
            sendEmail($email, $subject, $body);
            return ['status' => 1, 'msg' => 'Successfully subscribed to newsletter'];
        }

        return ['status' => 0, 'msg' => 'Failed to subscribe'];
    }

    public function notifySubscribers($blog) {
        // Get all active subscribers
        $subscribers = $this->getRecordsByField('status', 1);
        
        if (!$subscribers) {
            return false;
        }

        $subject = "New Blog Post: " . $blog['title'];
        $body = "
            <h2>New Blog Post Available!</h2>
            <p>We've just published a new blog post that you might be interested in:</p>
            <h3>{$blog['title']}</h3>
            <p>{$blog['short_desc']}</p>
            <p><a href='http://" . $_SERVER['HTTP_HOST'] . "/blog/blog.php?id={$blog['id']}'>Read More</a></p>
            <p>Best regards,<br>Blog Team</p>
        ";

        $successCount = 0;
        foreach ($subscribers as $subscriber) {
            if (sendEmail($subscriber['email'], $subject, $body)) {
                $successCount++;
            }
        }

        return $successCount > 0;
    }
}
?> 