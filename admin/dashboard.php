<?php
require_once '../function/config.php';
require_once '../function/admin_auth.php';

// Check admin authentication
checkAdminAuth();

// Get admin data
$admin = getAdminData();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MyPharmaRex Blog</title>
    <?php include 'head.php'; ?>   
    <style>
        .content {
    margin-left: 260px;
}
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <h1 class="mb-4">Manage Dashboard</h1>
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <h2 class="card-text" id="totalUsers">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Blogs</h5>
                            <h2 class="card-text" id="totalBlogs">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Categories</h5>
                            <h2 class="card-text" id="totalCategories">0</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title">Pending Blogs</h5>
                            <h2 class="card-text" id="pendingBlogs">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5 class="card-title">Rejected Blogs</h5>
                            <h2 class="card-text" id="rejectedBlogs">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Comments</h5>
                            <h2 class="card-text" id="totalComments">0</h2>
                        </div>
                    </div>
                </div>
            </div>
            
         
        </div>
    </div>

    
    <!-- Toast Message -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
        <div id="toastMessage" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastBody">Message</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <?php include 'script.php'; ?>
    <script>
        // Load dashboard statistics
        function loadDashboardStats() {
            console.log('Loading dashboard stats...'); // Debug log
            $.ajax({
                url: '../function/get_dashboard_stats.php',
                method: 'GET',
                dataType: 'json', // Explicitly specify we expect JSON
                success: function(response) {
                    console.log('Raw response:', response); // Debug log
                    
                    // Show debug information if available
                    if (response.debug) {
                        console.log('Debug information:', response.debug);
                    }
                    
                    // Update each stat with null check
                    $('#totalUsers').text(response.total_users || 0);
                    $('#totalBlogs').text(response.total_blogs || 0);
                    $('#totalCategories').text(response.total_categories || 0);
                    $('#pendingBlogs').text(response.pending_blogs || 0);
                    $('#rejectedBlogs').text(response.rejected_blogs || 0);
                    $('#totalComments').text(response.total_comments || 0);
                },
                error: function(xhr, status, error) {
                    console.error('Ajax error:', {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });
                }
            });
        }

        // Make sure jQuery is loaded
        if (typeof jQuery != 'undefined') {
            console.log('jQuery is loaded');
        } else {
            console.error('jQuery is not loaded!');
        }

        // Load stats when document is ready
        $(document).ready(function() {
            console.log('Document ready, loading stats...'); // Debug log
            loadDashboardStats();
        });

        // Also try loading stats after a short delay to ensure everything is loaded
        setTimeout(function() {
            console.log('Loading stats after delay...'); // Debug log
            loadDashboardStats();
        }, 1000);
    </script>
</body>
</html>
