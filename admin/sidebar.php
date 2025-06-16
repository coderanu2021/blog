<?php
require_once '../function/config.php';
$current_page = basename($_SERVER['PHP_SELF']);

// Function to check if table exists
function tableExists($conn, $table) {
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return mysqli_num_rows($result) > 0;
}
?>
<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="pending_posts.php" class="nav-link <?php echo $current_page == 'pending_posts.php' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-clock"></i>
                    <p>
                        Pending Posts
                        <?php
                        // Get count of pending posts
                        $sql = "SELECT COUNT(*) as count FROM tbl_blog WHERE status = " . BLOG_STATUS_PENDING;
                        $result = mysqli_query($conn, $sql);
                        $count = mysqli_fetch_assoc($result)['count'];
                        if ($count > 0) {
                            echo '<span class="badge badge-warning right">' . $count . '</span>';
                        }
                        ?>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="post_details.php" class="nav-link <?php echo $current_page == 'post_details.php' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>All Posts</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="category_details.php" class="nav-link <?php echo $current_page == 'category_details.php' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-folder"></i>
                    <p>Categories</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="comments.php" class="nav-link <?php echo $current_page == 'comments.php' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-comments"></i>
                    <p>
                        Comments
                        <?php
                        // Get count of pending comments if table exists
                        if (tableExists($conn, 'tbl_comments')) {
                            $sql = "SELECT COUNT(*) as count FROM tbl_comments WHERE status = 0";
                            $result = mysqli_query($conn, $sql);
                            $count = mysqli_fetch_assoc($result)['count'];
                            if ($count > 0) {
                                echo '<span class="badge badge-warning right">' . $count . '</span>';
                            }
                        }
                        ?>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="users.php" class="nav-link <?php echo $current_page == 'users.php' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Users</p>
                </a>
            </li>
        </ul>
    </nav>
</div>