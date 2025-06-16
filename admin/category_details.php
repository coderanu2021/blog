<?php
require_once '../function/config.php';
require_once '../function/admin_auth.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check admin authentication
checkAdminAuth();

// Get admin data
$admin = getAdminData();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $sql = "INSERT INTO tbl_blog_category (name) VALUES (?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $name);
                if (mysqli_stmt_execute($stmt)) {
                    $success = "Category added successfully!";
                } else {
                    $error = "Error adding category: " . mysqli_error($conn);
                }
                break;

            case 'update':
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $sql = "UPDATE tbl_blog_category SET name = ? WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "si", $name, $id);
                if (mysqli_stmt_execute($stmt)) {
                    $success = "Category updated successfully!";
                } else {
                    $error = "Error updating category: " . mysqli_error($conn);
                }
                break;

            case 'delete':
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $sql = "DELETE FROM tbl_blog_category WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $id);
                if (mysqli_stmt_execute($stmt)) {
                    $success = "Category deleted successfully!";
                } else {
                    $error = "Error deleting category: " . mysqli_error($conn);
                }
                break;
        }
    }
}

// Debug database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get all categories with detailed error reporting
$sql = "SELECT * FROM tbl_blog_category ORDER BY name ASC";
$result = mysqli_query($conn, $sql);

// Debug information

// Store all categories in an array
$categories = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management - Admin Panel</title>
    <?php include 'head.php'; ?>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'header.php'; ?>
        <?php include 'sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Category Management</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-4">
                            <!-- Add Category Form -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Add New Category</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <input type="hidden" name="action" value="add">
                                        <div class="form-group">
                                            <label for="name">Category Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Category</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <!-- Categories List -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">All Categories</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Created At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if (!empty($categories)) {
                                                    foreach ($categories as $row) {
                                                        echo '<tr>';
                                                        echo '<td>' . $row['id'] . '</td>';
                                                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                                                        echo '<td>' . date('d M Y', strtotime($row['created_at'])) . '</td>';
                                                        echo '<td>';
                                                        echo '<button type="button" class="btn btn-primary btn-sm edit-category" 
                                                                data-id="' . $row['id'] . '"
                                                                data-name="' . htmlspecialchars($row['name']) . '">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </button>';
                                                        echo '<button type="button" class="btn btn-danger btn-sm delete-category"
                                                                data-id="' . $row['id'] . '">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>';
                                                        echo '</td>';
                                                        echo '</tr>';
                                                    }
                                                } else {
                                                    echo '<tr><td colspan="4" class="text-center">No categories found</td></tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label for="edit_name">Category Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this category?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" id="delete_id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'script.php'; ?>
    
    <script>
    $(document).ready(function() {
        // Edit Category
        $('.edit-category').click(function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#editCategoryModal').modal('show');
        });

        // Delete Category
        $('.delete-category').click(function() {
            var id = $(this).data('id');
            $('#delete_id').val(id);
            $('#deleteCategoryModal').modal('show');
        });
    });
    </script>
</body>
</html> 