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

    $commentTable = new BaseManager('tbl_comment');
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
$commentTable = new BaseManager('tbl_comment');
$comments = $commentTable->getRecordsByField('blog_id', $blog_id, 'created_at DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($blog['title']); ?> - MyPharmaRex Blog</title>
  <?php include 'head.php'; ?>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #f8f9fa;
      color: #333;
      line-height: 1.6;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .blog-header {
      background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
      padding: 60px 0;
      margin-bottom: 50px;
      text-align: center;
      color: white;
      position: relative;
      overflow: hidden;
    }

    .blog-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><rect width="1" height="1" fill="rgba(255,255,255,0.1)"/></svg>');
      opacity: 0.1;
    }

    .blog-image {
      max-width: 100%;
      height: 400px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 25px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .blog-header h1 {
      font-size: 2.5em;
      font-weight: 700;
      margin-bottom: 15px;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .blog-meta {
      font-size: 1.1em;
      color: rgba(255,255,255,0.9);
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
    }

    .blog-meta span {
      display: flex;
      align-items: center;
    }

    .blog-meta span::before {
      content: '•';
      margin-right: 10px;
      color: rgba(255,255,255,0.5);
    }

    .blog-meta span:first-child::before {
      display: none;
    }

    .blog-content {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 40px;
      margin-bottom: 50px;
    }

    .main-content {
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .blog-text {
      font-size: 1.1em;
      line-height: 1.8;
      color: #444;
    }

    .blog-text p {
      margin-bottom: 1.5em;
    }

    .blog-text h2 {
      font-size: 1.8em;
      color: #1a1a1a;
      margin: 1.5em 0 1em;
    }

    .blog-text h3 {
      font-size: 1.5em;
      color: #1a1a1a;
      margin: 1.2em 0 0.8em;
    }

    .blog-text ul, .blog-text ol {
      margin: 1em 0;
      padding-left: 2em;
    }

    .blog-text li {
      margin-bottom: 0.5em;
    }

    .blog-text blockquote {
      border-left: 4px solid #4f46e5;
      padding: 1em 2em;
      margin: 1.5em 0;
      background: #f8f9fa;
      font-style: italic;
    }

    .blog-text img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      margin: 1.5em 0;
    }

    .sidebar {
      position: sticky;
      top: 20px;
    }

    .sidebar-section {
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }

    .sidebar-section h3 {
      font-size: 1.3em;
      color: #1a1a1a;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #f0f0f0;
    }

    .category-list {
      list-style: none;
    }

    .category-list li {
      margin-bottom: 15px;
    }

    .category-list a {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #333;
      transition: all 0.3s ease;
      padding: 10px;
      border-radius: 8px;
    }

    .category-list a:hover {
      background: #f8f9fa;
      color: #4f46e5;
      transform: translateX(5px);
    }

    .category-list img {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 15px;
    }

    .comments-section {
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .comments-section h2 {
      font-size: 1.8em;
      color: #1a1a1a;
      margin-bottom: 30px;
    }

    .comment-form {
      margin-bottom: 40px;
    }

    .comment-form textarea {
      width: 100%;
      padding: 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-bottom: 15px;
      font-family: inherit;
      resize: vertical;
      min-height: 100px;
    }

    .comment-form button {
      background: #4f46e5;
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .comment-form button:hover {
      background: #4338ca;
      transform: translateY(-2px);
    }

    .comment {
      border-bottom: 1px solid #eee;
      padding: 20px 0;
    }

    .comment:last-child {
      border-bottom: none;
    }

    .comment-header {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .comment-author {
      font-weight: 600;
      color: #1a1a1a;
    }

    .comment-date {
      color: #666;
      font-size: 0.9em;
      margin-left: 10px;
    }

    .comment-text {
      color: #444;
      line-height: 1.6;
    }

    @media (max-width: 768px) {
      .blog-content {
        grid-template-columns: 1fr;
      }

      .blog-header {
        padding: 40px 0;
      }

      .blog-header h1 {
        font-size: 2em;
      }

      .blog-image {
        height: 300px;
      }

      .main-content, .comments-section {
        padding: 25px;
      }
    }
  </style>
</head>
<body>

<?php include 'header.php' ?>

<div class="blog-header">
  <div class="container">
    <?php if (isset($blog['image']) && !empty($blog['image'])): ?>
      <img src="<?php echo htmlspecialchars($blog['image']); ?>" 
           alt="<?php echo htmlspecialchars($blog['title']); ?>"
           class="blog-image">
    <?php endif; ?>
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
