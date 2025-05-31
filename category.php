<?php
require_once 'function/BaseManager.php';

// Get category ID from URL
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Debug information
echo "<!-- Debug Info: Category ID: " . $category_id . " -->";

// Fetch category details
$categoryTable = new BaseManager('tbl_blog_category');
$category = $categoryTable->getRecordById($category_id);

// Debug information
echo "<!-- Debug Info: Category Data: ";
print_r($category);
echo " -->";

// If category not found, redirect to all blogs page
if (!$category) {
    header('Location: all_blogs.php');
    exit();
}

// Fetch blogs for this category
$blogTable = new BaseManager('tbl_blog');
$FETCH_ALL = $blogTable->getAllRecord();

// Filter blogs by category
$category_blogs = array_filter($FETCH_ALL, function($blog) use ($category_id) {
    return $blog['category_id'] == $category_id;
});

// Pagination logic
$perPage = 8; // Number of posts per page
$totalPosts = count($category_blogs);
$totalPages = ceil($totalPosts / $perPage);

// Get current page from URL, default is 1
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max(1, min($totalPages, $currentPage)); // Ensure the current page is valid

$startIndex = ($currentPage - 1) * $perPage;
$posts = array_slice($category_blogs, $startIndex, $perPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($category['name'] ?? 'Category Not Found'); ?> - MyPharmaRex Blog</title>
    <?php include 'head.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>

    <!-- Blog List Section -->
    <div class="container my-5">
        <h1 class="mb-4"><?php echo htmlspecialchars($category['name'] ?? 'Category Not Found'); ?></h1>
        <div class="row">
            <!-- Blog Posts -->
            <div class="col-lg-8 col-md-7 col-sm-12">
                <div class="row">
                    <?php if (empty($posts)): ?>
                        <div class="col-12">
                            <p>No blogs found in this category.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($posts as $row): ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card">
                                <img src="<?php echo htmlspecialchars($row['image'] ?? ''); ?>" class="card-img-top" alt="Blog Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['title'] ?? ''); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($row['short_desc'] ?? ''); ?></p>
                                    <a href="blog?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm">Read More</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?id=<?php echo $category_id; ?>&page=<?php echo $currentPage - 1; ?>">Previous</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                                <a class="page-link" href="?id=<?php echo $category_id; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?id=<?php echo $category_id; ?>&page=<?php echo $currentPage + 1; ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>

            <!-- Sidebar: Categories -->
            <div class="col-lg-4 col-md-5 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <ul class="list-group">
                            <?php
                            $categories = $categoryTable->getAllRecord();
                            foreach ($categories as $cat): 
                                // Count blogs in this category
                                $blogCount = count(array_filter($FETCH_ALL, function($blog) use ($cat) {
                                    return $blog['category_id'] == $cat['id'];
                                }));
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="category?id=<?php echo $cat['id']; ?>" class="text-decoration-none"><?php echo htmlspecialchars($cat['name'] ?? ''); ?></a>
                                    <span class="badge bg-primary rounded-pill"><?php echo $blogCount; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
