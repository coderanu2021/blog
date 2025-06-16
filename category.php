<?php
session_start();
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

// If category not found, redirect to all categories page
if (!$category) {
    header('Location: all_categories.php');
    exit();
}

// Fetch blogs in this category
$blogTable = new BaseManager('tbl_blog');
$blogs = $blogTable->getRecordsByField('category_id', $category_id, 'created_at DESC');

// Get category name safely
$categoryName = isset($category['name']) ? $category['name'] : 'Unnamed Category';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo htmlspecialchars($categoryName); ?> - MyPharmaRex Blog</title>
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

        .category-header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            padding: 60px 0;
            margin-bottom: 50px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .category-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><rect width="1" height="1" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.1;
        }

        .category-image {
            max-width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .category-header h1 {
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            padding: 20px 0;
        }

        .blog-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .blog-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .blog-card:hover .blog-image {
            transform: scale(1.05);
        }

        .blog-content {
            padding: 25px;
        }

        .blog-title {
            font-size: 1.3em;
            margin-bottom: 15px;
            color: #1a1a1a;
            line-height: 1.4;
        }

        .blog-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .blog-title a:hover {
            color: #4f46e5;
        }

        .blog-meta {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .blog-meta span {
            display: flex;
            align-items: center;
        }

        .blog-meta span::before {
            content: '•';
            margin-right: 10px;
            color: #4f46e5;
        }

        .blog-meta span:first-child::before {
            display: none;
        }

        .blog-excerpt {
            color: #555;
            line-height: 1.7;
            margin-bottom: 20px;
            font-size: 0.95em;
        }

        .read-more {
            display: inline-block;
            padding: 10px 20px;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .read-more:hover {
            background: #4338ca;
            transform: translateY(-2px);
        }

        .no-blogs {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .no-blogs h2 {
            font-size: 1.8em;
            color: #1a1a1a;
            margin-bottom: 15px;
        }

        .no-blogs p {
            color: #666;
            font-size: 1.1em;
        }

        @media (max-width: 768px) {
            .category-header {
                padding: 40px 0;
            }

            .category-header h1 {
                font-size: 2em;
            }

            .blog-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .blog-card {
                max-width: 500px;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
<?php include 'header.php' ?>

<div class="category-header">
    <div class="container">
        <?php if (isset($category['image']) && !empty($category['image'])): ?>
            <img src="<?php echo htmlspecialchars($category['image']); ?>" 
                 alt="<?php echo htmlspecialchars($categoryName); ?>"
                 class="category-image">
        <?php endif; ?>
        <h1><?php echo htmlspecialchars($categoryName); ?></h1>
    </div>
</div>

<div class="container">
    <div class="blog-grid">
        <?php if (!empty($blogs)): ?>
            <?php foreach ($blogs as $blog): 
                $author = null;
                if (isset($blog['user_id']) && !empty($blog['user_id'])) {
                    $userTable = new BaseManager('tbl_user');
                    $author = $userTable->getRecordById($blog['user_id']);
                }
            ?>
                <article class="blog-card">
                    <?php if (isset($blog['image']) && !empty($blog['image'])): ?>
                        <img src="<?php echo htmlspecialchars($blog['image']); ?>" 
                             alt="<?php echo htmlspecialchars($blog['title'] ?? 'Blog Post'); ?>"
                             class="blog-image">
                    <?php endif; ?>
                    
                    <div class="blog-content">
                        <h2 class="blog-title">
                            <a href="blog.php?id=<?php echo $blog['id']; ?>">
                                <?php echo htmlspecialchars($blog['title'] ?? 'Untitled Post'); ?>
                            </a>
                        </h2>
                        
                        <div class="blog-meta">
                            <?php if ($author && isset($author['name'])): ?>
                                <span>By <?php echo htmlspecialchars($author['name']); ?></span>
                            <?php endif; ?>
                            <?php if (isset($blog['created_at'])): ?>
                                <span><?php echo date('F j, Y', strtotime($blog['created_at'])); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="blog-excerpt">
                            <?php 
                            $excerpt = isset($blog['short_desc']) ? $blog['short_desc'] : '';
                            echo htmlspecialchars(substr($excerpt, 0, 150)) . (strlen($excerpt) > 150 ? '...' : ''); 
                            ?>
                        </div>
                        
                        <a href="blog.php?id=<?php echo $blog['id']; ?>" class="read-more">
                            Read More
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-blogs">
                <h2>No blogs found in this category yet.</h2>
                <p>Check back later for new content!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php' ?>
</body>
</html>
