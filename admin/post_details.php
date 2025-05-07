<?php 
require_once '../function/BaseManager.php';
$userTable = new BaseManager('tbl_blog');
$FETCH_ALL = $userTable->getAllRecord();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MyPharmaRex Blog</title>
    <?php include 'head.php'; ?>  
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> 


</head>
<body>
    <?php  include 'header.php'; ?>

<!-- Sidebar -->
<?php include 'sidebar.php';?>
<!-- Main Content -->
<div class="content">
    <div class="container-fluid">
        <!-- <h1 class="mb-4">Manage Blog Posts</h1> -->
        
        <!-- Add New Post Button -->
        <div class="mb-4 text-end">
            <a href="add_post" class="btn btn-add-new">Add New Patient</a>
        </div>
        
        <!-- Post Management Card -->
        <div class="card">
            <div class="card-header">All Blog Posts</div>
            <div class="card-body">
            <table id="example" class="display">
                <thead>
                    <tr>
                        <th>Sno</th>
                        <th>Title</th>
                        <th>Meta Title</th>
                        <th>Image</th>
                        <th>Category</th>
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
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['meta_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['category_id']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($row['image']); ?>" width="50" /></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td> Action</td>
                        </tr>
                    <?php endforeach; ?>

                  
                    <!-- Add more rows here -->
                </tbody>
            </table>

            </div>
        </div>
    </div>
</div>
<?php  include 'script.php';?>
<script>
      $(document).ready(function() {
      $('#example').DataTable();
  });
  </script>
<!-- Bootstrap JS -->
</body>
</html>
