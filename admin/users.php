<?php
require_once '../function/config.php';
require_once 'head.php';
require_once 'header.php';
require_once 'sidebar.php';

// Get all users
$sql = "SELECT * FROM tbl_user ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Management</h1>
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
                            <h3 class="card-title">All Users</h3>
                        </div>
                        <div class="card-body">
                            <table id="usersTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['phone_no']; ?></td>
                                        <td>
                                            <?php if($row['status'] == '1') { ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php } else { ?>
                                                <span class="badge badge-danger">Inactive</span>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                                        <td>
                                            <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm delete-user" data-id="<?php echo $row['id']; ?>">
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

<script>
$(document).ready(function() {
    $('#usersTable').DataTable();
    
    $('.delete-user').click(function() {
        if(confirm('Are you sure you want to delete this user?')) {
            var userId = $(this).data('id');
            $.ajax({
                url: 'ajax/delete_user.php',
                type: 'POST',
                data: {id: userId},
                success: function(response) {
                    if(response.success) {
                        location.reload();
                    } else {
                        alert('Error deleting user');
                    }
                }
            });
        }
    });
});
</script>

<?php require_once 'script.php'; ?> 