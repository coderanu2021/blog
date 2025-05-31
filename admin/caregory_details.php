<?php
require_once '../function/config.php';
require_once 'head.php';
require_once 'header.php';
require_once 'sidebar.php';

// Get all categories
$sql = "SELECT * FROM tbl_blog_category ORDER BY name";
$result = mysqli_query($conn, $sql);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Categories</h1>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addCategoryModal">
                        <i class="fas fa-plus"></i> Add New Category
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Categories</h3>
                        </div>
                        <div class="card-body">
                            <table id="categoriesTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td>
                                            <?php if($row['image']) { ?>
                                                <img src="../<?php echo $row['image']; ?>" alt="Category Image" style="max-width: 100px;">
                                            <?php } ?>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm edit-category" 
                                                    data-id="<?php echo $row['id']; ?>"
                                                    data-name="<?php echo $row['name']; ?>"
                                                    data-image="<?php echo $row['image']; ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm delete-category" data-id="<?php echo $row['id']; ?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addCategoryForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Category Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_category_id">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" name="name" id="edit_category_name" required>
                    </div>
                    <div class="form-group">
                        <label>Category Image</label>
                        <div id="current_image" class="mb-2"></div>
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#categoriesTable').DataTable();
    
    // Add Category Form Submit
    $('#addCategoryForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: 'ajax/add_category.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    location.reload();
                } else {
                    alert('Error adding category');
                }
            }
        });
    });
    
    // Edit Category Click
    $('.edit-category').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var image = $(this).data('image');
        
        $('#edit_category_id').val(id);
        $('#edit_category_name').val(name);
        
        if(image) {
            $('#current_image').html('<img src="../' + image + '" alt="Category Image" style="max-width: 200px;">');
        } else {
            $('#current_image').html('');
        }
        
        $('#editCategoryModal').modal('show');
    });
    
    // Edit Category Form Submit
    $('#editCategoryForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: 'ajax/edit_category.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    location.reload();
                } else {
                    alert('Error updating category');
                }
            }
        });
    });
    
    // Delete Category Click
    $('.delete-category').click(function() {
        if(confirm('Are you sure you want to delete this category?')) {
            var categoryId = $(this).data('id');
            $.ajax({
                url: 'ajax/delete_category.php',
                type: 'POST',
                data: {id: categoryId},
                success: function(response) {
                    if(response.success) {
                        location.reload();
                    } else {
                        alert('Error deleting category');
                    }
                }
            });
        }
    });
});
</script>

<?php require_once 'script.php'; ?>
