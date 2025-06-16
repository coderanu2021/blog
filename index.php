<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Discover Stories That Matter</title>
    <?php include 'head.php'; ?>
</head>
<body>
<?php
require_once 'function/config.php';

require_once 'header.php';

// Get featured posts
$sql = "SELECT b.*, c.name as category_name, u.name as author_name 
        FROM tbl_blog b 
        LEFT JOIN tbl_blog_category c ON b.category_id = c.id 
        LEFT JOIN tbl_user u ON b.user_id = u.id 
        WHERE b.status = " . BLOG_STATUS_APPROVED . "
        ORDER BY b.created_at DESC 
        LIMIT 6";
$featured_posts = mysqli_query($conn, $sql);

// Get all categories
$sql = "SELECT c.*, COUNT(b.id) as post_count 
        FROM tbl_blog_category c 
        LEFT JOIN tbl_blog b ON c.id = b.category_id 
        GROUP BY c.id 
        ORDER BY post_count DESC";
$categories = mysqli_query($conn, $sql);
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in">
                <h1 class="display-4 fw-bold mb-4">Discover Stories That Matter</h1>
                <p class="lead mb-4">Explore insightful articles, expert opinions, and engaging stories across various topics. Join our community of readers and writers.</p>
                <div class="d-flex gap-3">
                    <a href="all_blogs.php" class="btn btn-primary btn-lg">Explore Posts</a>
                    <a href="register.php" class="btn btn-outline-light btn-lg">Join Us</a>
                </div>
            </div>
            <div class="col-lg-6 fade-in">
                <img src="assets/images/blog/digital-marketing.jpg" alt="Blog Hero" class="img-fluid rounded-4 shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Featured Posts Section -->
<section class="featured-posts py-5">
    <div class="container">
        <h2 class="section-title text-center">Featured Posts</h2>
        <div class="row g-4">
            <?php while($post = mysqli_fetch_assoc($featured_posts)) { ?>
                <div class="col-md-4 fade-in">
                    <div class="blog-card h-100">
                        <?php if($post['image']) { ?>
                            <img src="<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>" class="card-img-top">
                        <?php } ?>
                        <div class="card-body">
                            <span class="category-badge"><?php echo $post['category_name']; ?></span>
                            <h3 class="card-title">
                                <a href="blog.php?id=<?php echo $post['id']; ?>" class="text-decoration-none text-dark">
                                    <?php echo $post['title']; ?>
                                </a>
                            </h3>
                            <p class="card-text"><?php echo substr($post['short_desc'], 0, 150) . '...'; ?></p>
                            <div class="card-meta">
                                <span><i class="fas fa-user"></i> <?php echo $post['author_name']; ?></span>
                                <span class="ms-3"><i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($post['created_at'])); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="text-center mt-5">
            <a href="all_blogs.php" class="btn btn-outline-primary btn-lg">View All Posts</a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">Browse by Category</h2>
        <div class="row g-4">
            <?php while($category = mysqli_fetch_assoc($categories)) { ?>
                <div class="col-md-4 fade-in">
                    <div class="category-card text-center p-4 bg-white rounded-4 shadow-sm">
                        <?php if($category['image']) { ?>
                            <img src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>" class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                        <?php } ?>
                        <h3 class="h4 mb-2"><?php echo $category['name']; ?></h3>
                        <p class="text-muted mb-3"><?php echo $category['post_count']; ?> Posts</p>
                        <a href="category.php?id=<?php echo $category['id']; ?>" class="btn btn-outline-primary">View Posts</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center fade-in">
                <h2 class="section-title">Stay Updated</h2>
                <p class="lead mb-4">Subscribe to our newsletter and never miss out on our latest posts and updates.</p>
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Enter your email address" required>
                        <button class="btn btn-primary" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
// Newsletter form submission
document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = this.querySelector('input[type="email"]').value;
    const messageDiv = this.querySelector('.subscription-message') || document.createElement('div');
    messageDiv.className = 'subscription-message mt-2';
    
    if(email) {
        fetch('function/subscribe.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'email=' + encodeURIComponent(email)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 1) {
                messageDiv.className = 'subscription-message mt-2 alert alert-success';
                this.reset();
            } else {
                messageDiv.className = 'subscription-message mt-2 alert alert-danger';
            }
            messageDiv.textContent = data.msg;
            if (!this.contains(messageDiv)) {
                this.appendChild(messageDiv);
            }
        })
        .catch(error => {
            messageDiv.className = 'subscription-message mt-2 alert alert-danger';
            messageDiv.textContent = 'An error occurred. Please try again later.';
            if (!this.contains(messageDiv)) {
                this.appendChild(messageDiv);
            }
        });
    }
});

// Add fade-in animation to elements as they come into view
const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
};

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.querySelectorAll('.fade-in').forEach(element => {
    observer.observe(element);
});
</script>

<?php require_once 'footer.php'; ?>
</body>
</html>
