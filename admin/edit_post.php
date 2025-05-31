<?php
require_once '../function/config.php';
require_once 'head.php';
require_once 'header.php';
require_once 'sidebar.php';

if(!isset($_GET['id'])) {
    header('Location: post_details.php');
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM tbl_blog WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);

if(!$post) {
    header('Location: post_details.php');
    exit();
}

// Get all categories
$sql = "SELECT * FROM tbl_blog_category ORDER BY name";
$categories = mysqli_query($conn, $sql);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $meta_title = mysqli_real_escape_string($conn, $_POST['meta_title']);
    $short_desc = mysqli_real_escape_string($conn, $_POST['short_desc']);
    $long_desc = mysqli_real_escape_string($conn, $_POST['long_desc']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Handle image upload
    $image = $post['image'];
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/posts/";
        if(!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Delete old image if exists
            if($post['image'] && file_exists('../' . $post['image'])) {
                unlink('../' . $post['image']);
            }
            $image = 'uploads/posts/' . $new_filename;
        }
    }
    
    $sql = "UPDATE tbl_blog SET 
            title = '$title',
            meta_title = '$meta_title',
            short_desc = '$short_desc',
            long_desc = '$long_desc',
            category_id = '$category_id',
            status = '$status',
            image = '$image'
            WHERE id = '$id'";
            
    if(mysqli_query($conn, $sql)) {
        $success = "Post updated successfully!";
        $post = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_blog WHERE id = '$id'"));
    } else {
        $error = "Error updating post!";
    }
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Blog Post</h1>
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
                            <h3 class="card-title">Edit Post Details</h3>
                        </div>
                        <div class="card-body">
                            <?php if(isset($success)) { ?>
                                <div class="alert alert-success"><?php echo $success; ?></div>
                            <?php } ?>
                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php } ?>
                            
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" value="<?php echo $post['title']; ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Meta Title</label>
                                    <input type="text" class="form-control" name="meta_title" value="<?php echo $post['meta_title']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" name="category_id" required>
                                        <option value="">Select Category</option>
                                        <?php while($category = mysqli_fetch_assoc($categories)) { ?>
                                            <option value="<?php echo $category['id']; ?>" <?php echo $post['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                                <?php echo $category['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Short Description</label>
                                    <textarea class="form-control" name="short_desc" rows="3"><?php echo $post['short_desc']; ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Long Description</label>
                                    <textarea class="form-control" name="long_desc" id="editor" rows="10"><?php echo $post['long_desc']; ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" <?php echo $post['status'] == '1' ? 'selected' : ''; ?>>Published</option>
                                        <option value="0" <?php echo $post['status'] == '0' ? 'selected' : ''; ?>>Draft</option>
                                        <option value="2" <?php echo $post['status'] == '2' ? 'selected' : ''; ?>>Archived</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Featured Image</label>
                                    <?php if($post['image']) { ?>
                                        <div class="mb-2">
                                            <img src="../<?php echo $post['image']; ?>" alt="Post Image" style="max-width: 200px;">
                                        </div>
                                    <?php } ?>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Update Post</button>
                                <a href="post_details.php" class="btn btn-default">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
</script>

<?php require_once 'script.php'; ?> 