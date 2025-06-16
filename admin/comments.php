<?php
require_once '../function/config.php';
require_once '../function/admin_auth.php';
checkAdminAuth();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle comment status update
if (isset($_POST['comment_id']) && isset($_POST['status'])) {
    $comment_id = mysqli_real_escape_string($conn, $_POST['comment_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $sql = "UPDATE tbl_comments SET status = '$status' WHERE id = '$comment_id'";
    if (mysqli_query($conn, $sql)) {
        $success = "Comment status updated successfully!";
    } else {
        $error = "Error updating comment status: " . mysqli_error($conn);
    }
}

// Handle comment deletion
if (isset($_POST['delete_comment'])) {
    $comment_id = mysqli_real_escape_string($conn, $_POST['comment_id']);
    
    $sql = "DELETE FROM tbl_comments WHERE id = '$comment_id'";
    if (mysqli_query($conn, $sql)) {
        $success = "Comment deleted successfully!";
    } else {
        $error = "Error deleting comment: " . mysqli_error($conn);
    }
}

// Debug database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get all comments with post and user information
$sql = "SELECT c.*, b.title as post_title, u.name as user_name 
        FROM tbl_comments c 
        LEFT JOIN tbl_blog b ON c.blog_id = b.id 
        LEFT JOIN tbl_user u ON c.user_id = u.id 
        ORDER BY c.created_at DESC";
$result = mysqli_query($conn, $sql);

// Debug information
if (!$result) {
    $error = "Database query error: " . mysqli_error($conn);
    echo "<!-- SQL Query: " . $sql . " -->";
    echo "<!-- Database Error: " . mysqli_error($conn) . " -->";
} else {
    $num_rows = mysqli_num_rows($result);
    echo "<!-- Number of comments found: " . $num_rows . " -->";
    
    // Debug table existence and structure
    $table_check_comments = mysqli_query($conn, "SHOW TABLES LIKE 'tbl_comments'");
    if (mysqli_num_rows($table_check_comments) == 0) {
        echo "<!-- Table 'tbl_comments' does not exist -->";
    } else {
        echo "<!-- Table 'tbl_comments' exists -->";
        $structure_comments = mysqli_query($conn, "DESCRIBE tbl_comments");
        echo "<!-- Table 'tbl_comments' Structure: -->";
        while ($row_structure = mysqli_fetch_assoc($structure_comments)) {
            echo "<!-- Field: " . $row_structure['Field'] . ", Type: " . $row_structure['Type'] . " -->";
        }
    }
    
    $table_check_blog = mysqli_query($conn, "SHOW TABLES LIKE 'tbl_blog'");
    if (mysqli_num_rows($table_check_blog) == 0) {
        echo "<!-- Table 'tbl_blog' does not exist -->";
    } else {
        echo "<!-- Table 'tbl_blog' exists -->";
    }
    
    $table_check_user = mysqli_query($conn, "SHOW TABLES LIKE 'tbl_user'");
    if (mysqli_num_rows($table_check_user) == 0) {
        echo "<!-- Table 'tbl_user' does not exist -->";
    } else {
        echo "<!-- Table 'tbl_user' exists -->";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Comments - Admin Panel</title>
    <?php include 'head.php'; ?>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'header.php'; ?>
        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Manage Comments</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Comments List -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Comments</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Post</th>
                                            <th>User</th>
                                            <th>Comment</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if ($result && mysqli_num_rows($result) > 0):
                                            while ($row = mysqli_fetch_assoc($result)): 
                                                // Debug each row
                                                echo "<!-- Row Data: " . htmlspecialchars(json_encode($row)) . " -->";
                                        ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo htmlspecialchars($row['post_title']); ?></td>
                                                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['comment']); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $row['status'] == 1 ? 'success' : 'warning'; ?>">
                                                        <?php echo $row['status'] == 1 ? 'Approved' : 'Pending'; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('Y-m-d H:i', strtotime($row['created_at'])); ?></td>
                                                <td>
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="comment_id" value="<?php echo $row['id']; ?>">
                                                        <?php if ($row['status'] == 0): ?>
                                                            <button type="submit" name="status" value="1" class="btn btn-success btn-sm">
                                                                Approve
                                                            </button>
                                                        <?php else: ?>
                                                            <button type="submit" name="status" value="0" class="btn btn-warning btn-sm">
                                                                Unapprove
                                                            </button>
                                                        <?php endif; ?>
                                                        <button type="submit" name="delete_comment" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('Are you sure you want to delete this comment?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php 
                                            endwhile;
                                        else:
                                        ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No comments found</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include 'footer.php'; ?>
    </div>
    <?php include 'script.php'; ?>
</body>
</html> 