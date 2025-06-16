<?php
require_once '../function/config.php';
require_once 'head.php';
require_once 'header.php';
require_once 'sidebar.php';

// Get pending blog posts with category and user information
$sql = "SELECT b.*, c.name as category_name, u.name as author_name, u.email as author_email 
        FROM tbl_blog b 
        LEFT JOIN tbl_blog_category c ON b.category_id = c.id 
        LEFT JOIN tbl_user u ON b.user_id = u.id 
        WHERE b.status = " . BLOG_STATUS_PENDING . "
        ORDER BY b.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pending Blog Posts</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Posts Awaiting Approval</h3>
                        </div>
                        <div class="card-body">
                            <table id="pendingPostsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Author</th>
                                        <th>Submitted On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($post = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $post['id']; ?></td>
                                            <td>
                                                <a href="view_post.php?id=<?php echo $post['id']; ?>">
                                                    <?php echo htmlspecialchars($post['title']); ?>
                                                </a>
                                            </td>
                                            <td><?php echo htmlspecialchars($post['category_name']); ?></td>
                                            <td>
                                                <?php echo htmlspecialchars($post['author_name']); ?>
                                                <br>
                                                <small class="text-muted"><?php echo htmlspecialchars($post['author_email']); ?></small>
                                            </td>
                                            <td><?php echo date('M d, Y H:i', strtotime($post['created_at'])); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success btn-sm" 
                                                            onclick="updatePostStatus(<?php echo $post['id']; ?>, <?php echo BLOG_STATUS_APPROVED; ?>)">
                                                        Approve
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" 
                                                            onclick="updatePostStatus(<?php echo $post['id']; ?>, <?php echo BLOG_STATUS_REJECTED; ?>)">
                                                        Reject
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function updatePostStatus(postId, status) {
    if (!confirm('Are you sure you want to ' + (status === 1 ? 'approve' : 'reject') + ' this post?')) {
        return;
    }

    $.ajax({
        url: '../function/update_blog_status.php',
        method: 'POST',
        data: {
            blog_id: postId,
            status: status
        },
        success: function(response) {
            const result = JSON.parse(response);
            if (result.status === 1) {
                alert(result.msg);
                location.reload();
            } else {
                alert('Error: ' + result.msg);
            }
        },
        error: function() {
            alert('An error occurred while updating the post status.');
        }
    });
}

$(document).ready(function() {
    $('#pendingPostsTable').DataTable({
        "order": [[4, "desc"]]
    });
});
</script>

<?php require_once 'footer.php'; ?> 