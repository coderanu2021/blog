<?php
require_once "function/BaseManager.php";
$userTable = new BaseManager("tbl_blog_category");
$FETCH_ALL = $userTable->getAllRecord();

// Debug information
echo "<!-- Debug Info: ";
print_r($FETCH_ALL);
echo " -->";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Categories - MyPharmaRex Blog</title>
    <?php include "head.php"; ?>
    <style>
        .CIRCULAR_IMAGE {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .mb-10 {
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>

    <!-- Main Content -->
    <div class="container my-5">
        <h2 class="category-title mb-4">All Categories</h2>

        <div class="row">
            <?php if (empty($FETCH_ALL)): ?>
                <div class="col-12">
                    <p>No categories found.</p>
                </div>
            <?php else: ?>
                <?php foreach ($FETCH_ALL as $row): ?>
                    <div class="col-md-3 mb-10">
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($row["image"]); ?>" class="card-img-top CIRCULAR_IMAGE" alt="<?php echo htmlspecialchars($row["name"]); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row["name"]); ?></h5>
                                <a href="category?id=<?php echo htmlspecialchars($row["id"]); ?>" class="btn btn-primary">View Blogs</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
