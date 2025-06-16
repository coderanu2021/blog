<?php
require_once '../function/BaseManager.php';
require_once '../function/ImageManager.php';
require_once '../function/subscriber_manager.php';

// Check if user is logged in and is admin
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $meta_title = $_POST['meta_title'] ?? '';
    $short_desc = $_POST['short_desc'] ?? '';
    $long_desc = $_POST['long_desc'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $status = $_POST['status'] ?? 1;

    if (empty($title) || empty($short_desc) || empty($long_desc) || empty($category_id)) {
        $error = 'All fields are required';
    } else {
        $blogTable = new BaseManager('tbl_blog');
        $imageManager = new ImageManager();

        $data = [
            'title' => $title,
            'meta_title' => $meta_title,
            'short_desc' => $short_desc,
            'long_desc' => $long_desc,
            'category_id' => $category_id,
            'user_id' => $_SESSION['user_id'],
            'status' => $status
        ];

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = $imageManager->uploadImage($_FILES['image'], 'blog');
            if ($uploadResult['success']) {
                $data['image'] = $uploadResult['path'];
            } else {
                $error = $uploadResult['message'];
            }
        }

        if (empty($error)) {
            $insertResult = $blogTable->insert($data);
            if ($insertResult) {
                // Get the newly created blog post
                $newBlog = $blogTable->getOne(['id' => $insertResult]);
                
                // Notify subscribers if blog is approved
                if ($newBlog['status'] == 1) {
                    $subscriberManager = new SubscriberManager();
                    $subscriberManager->notifySubscribers($newBlog);
                }
                
                $message = 'Blog post added successfully';
                // Clear form data
                $title = $meta_title = $short_desc = $long_desc = '';
                $category_id = '';
                $status = 1;
            } else {
                $error = 'Failed to add blog post';
            }
        }
    }
}

// Fetch categories for dropdown
$categoryTable = new BaseManager('tbl_blog_category');
$categories = $categoryTable->getAllRecord();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Blog Post - Admin Panel</title>
    <?php include 'head.php'; ?>
    <style>
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        textarea.form-control {
            min-height: 100px;
        }

        .image-preview {
            max-width: 300px;
            margin-top: 10px;
            display: none;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
<?php include 'header.php' ?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php' ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left:260px;">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add New Blog Post</h1>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title" value="<?php echo htmlspecialchars($meta_title ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="short_desc">Short Description</label>
                    <textarea class="form-control" id="short_desc" name="short_desc" required><?php echo htmlspecialchars($short_desc ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="long_desc">Long Description</label>
                    <textarea class="form-control" id="long_desc" name="long_desc" required><?php echo htmlspecialchars($long_desc ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" <?php echo (isset($category_id) && $category_id == $category['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Featured Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                    <img id="imagePreview" class="image-preview" src="#" alt="Image Preview">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="1" <?php echo (isset($status) && $status == 1) ? 'selected' : ''; ?>>Active</option>
                        <option value="0" <?php echo (isset($status) && $status == 0) ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Add Blog Post</button>
            </form>
        </main>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php require_once 'footer.php'; ?>
</body>
</html>
