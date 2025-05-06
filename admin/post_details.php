<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Title - MyPharmaRex Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Sidebar Styles */
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #2c3e50;
            padding-top: 30px;
            transition: all 0.3s ease;
        }
        .sidebar a {
            color: #ecf0f1;
            padding: 15px;
            text-decoration: none;
            display: block;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #16a085;
            color: #fff;
            border-radius: 5px;
        }
        .sidebar h3 {
            color: #ecf0f1;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .sidebar .active {
            background-color: #16a085;
        }

        /* Content area */
        .content {
            margin-left: 260px;
            padding: 30px;
        }
        .card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .card-body {
            padding: 20px;
        }
        .table thead {
            background-color: #16a085;
            color: white;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-add-new {
            background-color: #28a745;
            color: white;
            font-size: 1.1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn-add-new:hover {
            background-color: #218838;
        }

        /* Blog Post Styling */
        .post-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .post-meta {
            font-size: 1rem;
            color: #555;
            margin-bottom: 20px;
        }
        .post-image {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .comment-section {
            margin-top: 30px;
        }
        .comment-box {
            margin-bottom: 15px;
        }
        .comment-box p {
            margin: 0;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h3>MyPharmaRex Blog</h3>
    <a href="#">Home</a>
    <a href="#">Blog</a>
    <a href="#">About</a>
    <a href="#">Contact</a>
    <a href="#">Categories</a>
    <a href="#">Archives</a>
</div>

<!-- Content -->
<div class="content">
    <div class="container">
        <h1 class="post-title">Post Title</h1>
        <p class="post-meta">Posted on May 6, 2025 by John Doe</p>
        <img src="https://via.placeholder.com/800x300" alt="Post Image" class="post-image">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse euismod sapien non libero blandit, in pharetra enim interdum. Integer tincidunt arcu vitae purus ultricies, vel suscipit ligula sodales. Quisque eu ex id tortor convallis maximus. Nam finibus, purus ac tristique sodales, elit purus aliquam ligula, vel consequat odio metus at ligula. Integer sit amet ex sed urna blandit vehicula. Vivamus accumsan ex nec sapien efficitur, vitae ultricies turpis fringilla.</p>
        
        <hr>

        <!-- Comment Section -->
        <div class="comment-section">
            <h4>Comments</h4>
            
            <!-- Comment Form -->
            <div class="mb-3 comment-box">
                <input type="text" class="form-control mb-2" placeholder="Your name">
                <textarea class="form-control mb-2" placeholder="Write a comment..."></textarea>
                <button class="btn btn-primary">Submit Comment</button>
            </div>

            <!-- Sample Comment -->
            <div class="border p-2 mb-2 comment-box">
                <p><strong>Jane Doe:</strong></p>
                <p>Great post! Thanks for sharing.</p>
            </div>

            <!-- Another Sample Comment -->
            <div class="border p-2 mb-2 comment-box">
                <p><strong>John Smith:</strong></p>
                <p>Interesting read, looking forward to more articles like this!</p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
