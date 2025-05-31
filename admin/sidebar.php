<div class="sidebar slide-in">
    <h3>Admin Panel</h3>
    <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a href="post_details.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'post_details.php' ? 'active' : ''; ?>">
        <i class="fas fa-file-alt"></i> Posts
    </a>
    <a href="caregory_details.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'caregory_details.php' ? 'active' : ''; ?>">
        <i class="fas fa-folder"></i> Categories
    </a>
    <a href="users.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
        <i class="fas fa-users"></i> Users
    </a>
    <a href="comments.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'comments.php' ? 'active' : ''; ?>">
        <i class="fas fa-comments"></i> Comments
    </a>
    <a href="settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
        <i class="fas fa-cog"></i> Settings
    </a>
</div>