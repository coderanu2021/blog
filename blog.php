<?php
session_start();
require_once 'function/BaseManager.php';
require_once 'function/ImageManager.php';

// Get blog ID from URL
$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch blog details
$blogTable = new BaseManager('tbl_blog');
$blog = $blogTable->getRecordById($blog_id);

// If blog not found, redirect to all blogs page
if (!$blog) {
    header('Location: all_blogs.php');
    exit();
}

// Fetch category details
$categoryTable = new BaseManager('tbl_blog_category');
$category = $categoryTable->getRecordById($blog['category_id']);

// Fetch all categories for sidebar
$allCategories = $categoryTable->getAllRecord();

// Fetch author details if user_id exists
$author = null;
if ($blog['user_id']) {
    $userTable = new BaseManager('tbl_user');
    $author = $userTable->getRecordById($blog['user_id']);
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
        exit();
    }

    $commentTable = new BaseManager('tbl_comments');
    $commentData = [
        'blog_id' => $blog_id,
        'user_id' => $_SESSION['user_id'],
        'comment' => $_POST['comment'],
        'status' => 1
    ];
    
    if ($commentTable->insert($commentData)) {
        header('Location: ' . $_SERVER['REQUEST_URI'] . '#comments');
        exit();
    }
}

// Fetch comments
$commentTable = new BaseManager('tbl_comments');
$comments = $commentTable->getRecordsByField('blog_id', $blog_id, 'created_at DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($blog['title']); ?> - MyPharmaRex Blog</title>
  <?php include 'head.php'; ?>
  <link rel="stylesheet" href="assets/css/blog.css">
</head>
<body class="bg-light">

<?php include 'header.php' ?>

<div class="blog-header">
  <div class="container">
    <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
    <div class="blog-meta">
      <?php if ($author && isset($author['name'])): ?>
        <span>By <?php echo htmlspecialchars($author['name']); ?></span>
      <?php endif; ?>
      <?php if ($category && isset($category['name'])): ?>
        <span>In <?php echo htmlspecialchars($category['name']); ?></span>
      <?php endif; ?>
      <?php if (isset($blog['created_at'])): ?>
        <span><?php echo date('F j, Y', strtotime($blog['created_at'])); ?></span>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="container">
  <div class="blog-content">
    <main class="main-content">
      <?php if (isset($blog['image']) && !empty($blog['image'])): ?>
        <img src="<?php echo htmlspecialchars($blog['image']); ?>" 
             alt="<?php echo htmlspecialchars($blog['title']); ?>"
             class="blog-image">
      <?php endif; ?>
      <article class="blog-text">
        <?php echo $blog['long_desc']; ?>
      </article>

      <section class="comments-section">
        <h2>Comments</h2>
        
        <?php if (isset($_SESSION['user_id'])): ?>
          <form class="comment-form" method="POST">
            <textarea name="comment" placeholder="Write your comment..." required></textarea>
            <button type="submit" name="submit_comment">Post Comment</button>
          </form>
        <?php else: ?>
          <p>Please <a href="login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">login</a> to post a comment.</p>
        <?php endif; ?>

        <?php if (!empty($comments)): ?>
          <?php foreach ($comments as $comment): 
            $commentAuthor = $userTable->getRecordById($comment['user_id']);
          ?>
            <div class="comment">
              <div class="comment-header">
                <span class="comment-author">
                  <?php echo htmlspecialchars($commentAuthor['name'] ?? 'Anonymous'); ?>
                </span>
                <span class="comment-date">
                  <?php echo date('F j, Y', strtotime($comment['created_at'])); ?>
                </span>
              </div>
              <div class="comment-text">
                <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No comments yet. Be the first to comment!</p>
        <?php endif; ?>
      </section>
    </main>

    <aside class="sidebar">
      <div class="sidebar-section">
        <h3>Blog Categories</h3>
        <ul class="category-list">
          <?php foreach ($allCategories as $cat): ?>
            <li>
              <a href="category.php?id=<?php echo $cat['id']; ?>">
                <?php if (isset($cat['image']) && !empty($cat['image'])): ?>
                  <img src="<?php echo htmlspecialchars($cat['image']); ?>" 
                       alt="<?php echo htmlspecialchars($cat['name']); ?>">
                <?php endif; ?>
                <?php echo htmlspecialchars($cat['name']); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <?php if ($category): ?>
        <div class="sidebar-section">
          <h3>Category Information</h3>
          <?php if (isset($category['image']) && !empty($category['image'])): ?>
            <img src="<?php echo htmlspecialchars($category['image']); ?>" 
                 alt="<?php echo htmlspecialchars($category['name']); ?>"
                 style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
          <?php endif; ?>
          <h4><?php echo htmlspecialchars($category['name']); ?></h4>
          <?php if (isset($category['description'])): ?>
            <p><?php echo htmlspecialchars($category['description']); ?></p>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </aside>
  </div>
</div>

<?php include 'footer.php' ?>
</body>
</html>
