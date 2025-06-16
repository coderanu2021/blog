<?php
require_once "function/Database.php";

try {
    $db = (new Database())->connect();
    
    // SQL to insert categories
    $sql = "INSERT INTO `tbl_blog_category` (`name`, `image`) VALUES
    ('Technology', 'assets/images/categories/technology.jpg'),
    ('Health & Wellness', 'assets/images/categories/health.jpg'),
    ('Travel', 'assets/images/categories/travel.jpg'),
    ('Food & Cooking', 'assets/images/categories/food.jpg'),
    ('Lifestyle', 'assets/images/categories/lifestyle.jpg'),
    ('Business', 'assets/images/categories/business.jpg'),
    ('Education', 'assets/images/categories/education.jpg'),
    ('Entertainment', 'assets/images/categories/entertainment.jpg'),
    ('Sports', 'assets/images/categories/sports.jpg')";
    
    $db->exec($sql);
    echo "Categories inserted successfully!";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 