<?php
require_once '../function/config.php';
require_once 'head.php';
require_once 'header.php';
require_once 'sidebar.php';

// Get all blog posts with category and user information
$sql = "SELECT b.*, c.name as category_name, u.name as author_name 
        FROM tbl_blog b 
        LEFT JOIN tbl_blog_category c ON b.category_id = c.id 
        LEFT JOIN tbl_user u ON b.user_id = u.id 
        ORDER BY b.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Blog Posts</h1>
                </div>
                <div class="col-sm-6">
                    <a href="add_post.php" class="btn btn-primary float-right">
                        <i class="fas fa-plus"></i> Add New Post
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
                            <h3 class="card-title">All Blog Posts</h3>
                        </div>
                        <div class="card-body">
                            <table id="postsTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['title']; ?></td>
                                        <td><?php echo $row['category_name']; ?></td>
                                        <td><?php echo $row['author_name']; ?></td>
                                        <td>
                                            <?php if($row['status'] == '1') { ?>
                                                <span class="badge badge-success">Published</span>
                                            <?php } elseif($row['status'] == '0') { ?>
                                                <span class="badge badge-warning">Draft</span>
                                            <?php } else { ?>
                                                <span class="badge badge-danger">Archived</span>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                                        <td>
                                            <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm delete-post" data-id="<?php echo $row['id']; ?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                            <a href="../blog.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm" target="_blank">
                                                <i class="fas fa-eye"></i> View
                                            </a>
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
$(document).ready(function() {
    $('#postsTable').DataTable();
    
    $('.delete-post').click(function() {
        if(confirm('Are you sure you want to delete this post?')) {
            var postId = $(this).data('id');
            $.ajax({
                url: 'ajax/delete_post.php',
                type: 'POST',
                data: {id: postId},
                success: function(response) {
                    if(response.success) {
                        location.reload();
                    } else {
                        alert('Error deleting post');
                    }
                }
            });
        }
    });
});
</script>

<?php require_once 'script.php'; ?>
