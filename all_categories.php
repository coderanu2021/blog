<?php
require_once "function/BaseManager.php";
$userTable = new BaseManager("tbl_blog_category");
$FETCH_ALL = $userTable->getAllRecord();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> All Category </title>
 <?php include "head.php"; ?>

</head>
<body>

<?php include "header.php"; ?>
<!-- Hero Section -->


<!-- Main Content -->
<div class="container">

    <!-- Featured Section -->
    <h2 class="category-title">All Categories</h2>

    <div class="row">
    <?php
    $i = 0;
    foreach ($FETCH_ALL as $row): $i++; ?>
 <div class="col-md-3 mb-10">
    <div class="card">
        <img src="<?php echo htmlspecialchars($row["image"]); ?>" class="card-img-top CIRCULAR_IMAGE" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($row["title"]); ?></h5>
            <a href="category?id=<?php echo htmlspecialchars($row["id"]); ?>" class="btn btn-primary">View Blog</a>
        </div>
        </div>
        </div>
  
<?php endforeach; ?>

 
</div>

<!-- Footer -->
<footer class="text-center">
    <div class="container">
        &copy; 2025 MyPharmaRex Blog. All rights reserved.
        <div class="mt-2">
            <a href="#" class="text-light mx-2">Privacy</a>
            <a href="#" class="text-light mx-2">Terms</a>
            <a href="#" class="text-light mx-2">Contact</a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
