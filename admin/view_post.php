<?php
require_once '../function/config.php';
require_once 'head.php';
require_once 'header.php';
require_once 'sidebar.php';

// Get post ID from URL
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get post details with category and author information
$sql = "SELECT b.*, c.name as category_name, u.name as author_name, u.email as author_email 
        FROM tbl_blog b 
        LEFT JOIN tbl_blog_category c ON b.category_id = c.id 
        LEFT JOIN tbl_user u ON b.user_id = u.id 
        WHERE b.id = $post_id";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);

if (!$post) {
    header('Location: pending_posts.php');
    exit();
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Blog Post</h1>
                </div>
                <div class="col-sm-6">
                    <a href="pending_posts.php" class="btn btn-secondary float-right">
                        <i class="fas fa-arrow-left"></i> Back to Pending Posts
                    </a>
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
                            <h3 class="card-title">Post Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                                    <div class="post-meta mb-4">
                                        <span class="mr-3">
                                            <i class="fas fa-user"></i> 
                                            <?php echo htmlspecialchars($post['author_name']); ?>
                                        </span>
                                        <span class="mr-3">
                                            <i class="fas fa-folder"></i> 
                                            <?php echo htmlspecialchars($post['category_name']); ?>
                                        </span>
                                        <span>
                                            <i class="fas fa-calendar"></i> 
                                            <?php echo date('M d, Y H:i', strtotime($post['created_at'])); ?>
                                        </span>
                                    </div>
                                    
                                    <?php if($post['image']) { ?>
                                        <div class="post-image mb-4">
                                            <img src="../<?php echo htmlspecialchars($post['image']); ?>" 
                                                 alt="<?php echo htmlspecialchars($post['title']); ?>" 
                                                 class="img-fluid">
                                        </div>
                                    <?php } ?>

                                    <div class="post-content">
                                        <h4>Short Description</h4>
                                        <p><?php echo nl2br(htmlspecialchars($post['short_desc'])); ?></p>
                                        
                                        <h4>Full Content</h4>
                                        <div class="long-content">
                                            <?php echo nl2br(htmlspecialchars($post['long_desc'])); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Post Status</h3>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                <strong>Current Status:</strong>
                                                <?php
                                                $statusClass = '';
                                                $statusText = '';
                                                switch($post['status']) {
                                                    case BLOG_STATUS_PENDING:
                                                        $statusClass = 'warning';
                                                        $statusText = 'Pending';
                                                        break;
                                                    case BLOG_STATUS_APPROVED:
                                                        $statusClass = 'success';
                                                        $statusText = 'Approved';
                                                        break;
                                                    case BLOG_STATUS_REJECTED:
                                                        $statusClass = 'danger';
                                                        $statusText = 'Rejected';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge badge-<?php echo $statusClass; ?>">
                                                    <?php echo $statusText; ?>
                                                </span>
                                            </p>
                                            
                                            <?php if($post['status'] == BLOG_STATUS_PENDING) { ?>
                                                <div class="mt-3">
                                                    <button type="button" class="btn btn-success btn-block mb-2" 
                                                            onclick="updatePostStatus(<?php echo $post['id']; ?>, <?php echo BLOG_STATUS_APPROVED; ?>)">
                                                        Approve Post
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-block" 
                                                            onclick="updatePostStatus(<?php echo $post['id']; ?>, <?php echo BLOG_STATUS_REJECTED; ?>)">
                                                        Reject Post
                                                    </button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <h3 class="card-title">Author Information</h3>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Name:</strong> <?php echo htmlspecialchars($post['author_name']); ?></p>
                                            <p><strong>Email:</strong> <?php echo htmlspecialchars($post['author_email']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
</script>

<?php require_once 'footer.php'; ?> 