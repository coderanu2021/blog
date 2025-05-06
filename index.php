<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://via.placeholder.com/1600x600') center/cover no-repeat;
            color: #fff;
            padding: 80px 0;
            text-align: center;
        }
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }
        .card-img-top {
            height: 180px;
            object-fit: cover;
        }
        .category-title {
            margin: 40px 0 20px;
            border-bottom: 2px solid #009990;
            display: inline-block;
            padding-bottom: 5px;
        }
        footer {
            background: #343a40;
            color: #fff;
            padding: 20px 0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">MyPharmaRex Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Stay Updated on Health & Wellness</h1>
        <p>Explore expert tips, latest research, and wellness trends</p>
        <a href="#" class="btn btn-success mt-3">Subscribe Now</a>
    </div>
</section>

<!-- Main Content -->
<div class="container my-5">

    <!-- Featured Section -->
    <h2 class="category-title">Featured Post</h2>
    <div class="row mb-5">
        <div class="col-md-6">
            <img src="https://via.placeholder.com/800x500" class="img-fluid rounded" alt="Featured">
        </div>
        <div class="col-md-6">
            <h3>Breaking: New Advances in Heart Health</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque feugiat justo et lorem cursus, nec bibendum est pretium.</p>
            <a href="#" class="btn btn-primary mt-2">Read More</a>
        </div>
    </div>

    <!-- Category: Health -->
    <h2 class="category-title">Health</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/600x400" class="card-img-top" alt="Health Post">
                <div class="card-body">
                    <h5 class="card-title">5 Ways to Boost Immunity</h5>
                    <p class="card-text">Discover natural ways to strengthen your immune system...</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/600x400" class="card-img-top" alt="Health Post">
                <div class="card-body">
                    <h5 class="card-title">Understanding Mental Health</h5>
                    <p class="card-text">Mental health matters — learn how to manage stress effectively.</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Category: Fitness -->
    <h2 class="category-title">Fitness</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/600x400" class="card-img-top" alt="Fitness Post">
                <div class="card-body">
                    <h5 class="card-title">10-Minute Home Workouts</h5>
                    <p class="card-text">No gym? No problem. Get fit with these quick routines.</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/600x400" class="card-img-top" alt="Fitness Post">
                <div class="card-body">
                    <h5 class="card-title">Yoga for Beginners</h5>
                    <p class="card-text">A gentle introduction to the basics of yoga and mindfulness.</p>
                    <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar: Trending Posts -->
    <h2 class="category-title">Trending Posts</h2>
    <ul class="list-group mb-5">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            How to Eat Healthy on a Budget
            <span class="badge bg-success rounded-pill">Hot</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Best Supplements for 2025
            <span class="badge bg-success rounded-pill">New</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Importance of Regular Checkups
            <span class="badge bg-success rounded-pill">Popular</span>
        </li>
    </ul>

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
