<?php
require_once '../function/config.php';
require_once 'head.php';
require_once 'header.php';
require_once 'sidebar.php';

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
    $user_id = $_SESSION['user_id']; // Assuming you have user session
    
    // Handle image upload
    $image = '';
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/posts/";
        if(!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = 'uploads/posts/' . $new_filename;
        }
    }
    
    $sql = "INSERT INTO tbl_blog (title, meta_title, short_desc, long_desc, category_id, user_id, status, image, created_at) 
            VALUES ('$title', '$meta_title', '$short_desc', '$long_desc', '$category_id', '$user_id', '$status', '$image', NOW())";
            
    if(mysqli_query($conn, $sql)) {
        $success = "Post added successfully!";
        // Clear form data
        $_POST = array();
    } else {
        $error = "Error adding post!";
    }
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add New Blog Post</h1>
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
                            <h3 class="card-title">Add New Post</h3>
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
                                    <input type="text" class="form-control" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Meta Title</label>
                                    <input type="text" class="form-control" name="meta_title" value="<?php echo isset($_POST['meta_title']) ? $_POST['meta_title'] : ''; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" name="category_id" required>
                                        <option value="">Select Category</option>
                                        <?php while($category = mysqli_fetch_assoc($categories)) { ?>
                                            <option value="<?php echo $category['id']; ?>" <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                                <?php echo $category['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Short Description</label>
                                    <textarea class="form-control" name="short_desc" rows="3"><?php echo isset($_POST['short_desc']) ? $_POST['short_desc'] : ''; ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Long Description</label>
                                    <textarea class="form-control" name="long_desc" id="editor" rows="10"><?php echo isset($_POST['long_desc']) ? $_POST['long_desc'] : ''; ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" <?php echo (isset($_POST['status']) && $_POST['status'] == '1') ? 'selected' : ''; ?>>Published</option>
                                        <option value="0" <?php echo (isset($_POST['status']) && $_POST['status'] == '0') ? 'selected' : ''; ?>>Draft</option>
                                        <option value="2" <?php echo (isset($_POST['status']) && $_POST['status'] == '2') ? 'selected' : ''; ?>>Archived</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Featured Image</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Add Post</button>
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
