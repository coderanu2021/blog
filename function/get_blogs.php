<?php
session_start();
require_once 'BaseManager.php';

// Get all blogs with author and category information
$blogTable = new BaseManager('tbl_blog');
$userTable = new BaseManager('tbl_user');
$categoryTable = new BaseManager('tbl_blog_category');

$blogs = $blogTable->getAll();

// Add author and category information to each blog
foreach ($blogs as &$blog) {
    // Get author information
    $author = $userTable->getOne(['id' => $blog['user_id']]);
    $blog['author_name'] = $author ? $author['name'] : 'Unknown';
    
    // Get category information
    $category = $categoryTable->getOne(['id' => $blog['category_id']]);
    $blog['category_name'] = $category ? $category['name'] : 'Uncategorized';
}

echo json_encode($blogs);
?> 