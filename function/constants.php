<?php
// Blog status constants
if (!defined('BLOG_STATUS_PENDING')) {
    define('BLOG_STATUS_PENDING', 0);
}
if (!defined('BLOG_STATUS_APPROVED')) {
    define('BLOG_STATUS_APPROVED', 1);
}
if (!defined('BLOG_STATUS_REJECTED')) {
    define('BLOG_STATUS_REJECTED', 2);
}

// User role constants
if (!defined('USER_ROLE_ADMIN')) {
    define('USER_ROLE_ADMIN', 'admin');
}
if (!defined('USER_ROLE_USER')) {
    define('USER_ROLE_USER', 'user');
}

// Other constants
if (!defined('UPLOAD_PATH')) {
    define('UPLOAD_PATH', 'uploads/');
}
if (!defined('ALLOWED_IMAGE_TYPES')) {
    define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
}
if (!defined('MAX_FILE_SIZE')) {
    define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
}
?> 