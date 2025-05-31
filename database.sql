-- Create database
CREATE DATABASE IF NOT EXISTS blog_db;
USE blog_db;

-- Users table
CREATE TABLE IF NOT EXISTS tbl_user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone_no VARCHAR(20),
    profile_photo VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Blog categories table
CREATE TABLE IF NOT EXISTS tbl_blog_category (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Blog posts table
CREATE TABLE IF NOT EXISTS tbl_blog (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    meta_title VARCHAR(255),
    short_desc TEXT,
    long_desc LONGTEXT,
    image VARCHAR(255),
    category_id INT,
    user_id INT,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES tbl_blog_category(id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES tbl_user(id) ON DELETE SET NULL
);

-- Comments table
CREATE TABLE IF NOT EXISTS tbl_comment (
    id INT PRIMARY KEY AUTO_INCREMENT,
    blog_id INT,
    user_id INT,
    comment TEXT NOT NULL,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_id) REFERENCES tbl_blog(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES tbl_user(id) ON DELETE SET NULL
);

-- Newsletter subscribers table
CREATE TABLE IF NOT EXISTS tbl_newsletter (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL UNIQUE,
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user
INSERT INTO tbl_user (name, email, password, role) VALUES 
('Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert some default categories
INSERT INTO tbl_blog_category (name) VALUES 
('Technology'),
('Health & Wellness'),
('Travel'),
('Food & Cooking'),
('Lifestyle'),
('Business'); 