<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MyPharmaRex Blog</title>
    <?php include 'head.php'; ?>   


</head>
<body>
    <?php  include 'header.php'; ?>

<!-- Sidebar -->
<?php  include 'sidebar.php';?>
<!-- Main Content -->
<div class="content">
    <div class="container-fluid">
        <h1 class="mb-4">Manage Blog Posts</h1>
        
        <!-- Add New Post Button -->
        <div class="mb-4 text-end">
            <a href="add_post" class="btn btn-add-new">Add New Post</a>
        </div>
        
        <!-- Post Management Card -->
        <div class="card">
            <div class="card-header">All Blog Posts</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sample Post 1</td>
                            <td>John Doe</td>
                            <td>Health</td>
                            <td>May 6, 2025</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Sample Post 2</td>
                            <td>Jane Smith</td>
                            <td>Fitness</td>
                            <td>May 5, 2025</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        <!-- More posts can be added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php  include 'script.php';?>

<!-- Bootstrap JS -->
</body>
</html>
