<?php 
require_once '../function/BaseManager.php';
$userTable = new BaseManager('tbl_blog_category');
$FETCH_ALL = $userTable->getAllRecord();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Category - My Blog</title>
    
    <?php include 'head.php'; ?>  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  
</head>

<body>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="content">
    <div class="container-fluid">
        <!-- Add New Post Button -->
        <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add New Category
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Blog Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <!-- Example Form (customize as needed) -->
                <form id="ADD_CATEGORY" enctype="multipart/form-data">
                <div class="mb-3">
                        <label for="categoryTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="categoryTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="imageURL" class="form-label">Image URL</label>
                        <input type="file" class="form-control" id="imageURL" name="image" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
              </div>
              
            </div>
          </div>
        </div>
        <div class="position-fixed top-0 end-0" style="z-index: 1050">
            <div id="toastMessage" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastBody">Message</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            </div>
        </div>

        <!-- Blog Posts Table -->
        <div class="card">
            <div class="card-header">All Blog Categories</div>
            <div class="card-body">
                <table id="example" class="display table table-striped">
                    <thead>
                        <tr>
                            <th>Sno</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                        $i = 0;
                        foreach($FETCH_ALL as $row): 
                            $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($row['image']); ?>" width="50" alt="Image" /></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td><a href="#"><i class="fa fa-edit"></i>
                            </a><a href="#"><i class="fa fa-trash"></i>
                            </a></td>
                        
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'script.php'; ?>

<script>
    $(document).ready(function() {
    // Handle form submission
    $('#ADD_CATEGORY').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        // Create FormData object to handle file uploads
        var formData = new FormData(this);

        $.ajax({
            url: '../function/add_category.php', // Path to your PHP file
            type: 'POST',
            data: formData,
            contentType: false, // Required for file uploads
            processData: false, // Required for file uploads
            dataType: 'json',
            success: function(response) {
                // Show toast message
                $('#toastBody').text(response.msg);
                $('#toastMessage').toast({ delay: 3000 }).toast('show');

                if (response.status === 1) {
                    // Optionally, reload the page or update the table dynamically
                    setTimeout(function() {
                        location.reload(); // Reload to show new category
                    }, 2000);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                $('#toastBody').text('An error occurred: ' + error);
                $('#toastMessage').removeClass('bg-success').addClass('bg-danger').toast({ delay: 3000 }).toast('show');
            }
        });
    });
});
</script>
</body>
</html>
