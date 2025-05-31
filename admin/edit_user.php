<?php
require_once '../function/config.php';
require_once 'head.php';
require_once 'header.php';
require_once 'sidebar.php';

if(!isset($_GET['id'])) {
    header('Location: users.php');
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM tbl_user WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if(!$user) {
    header('Location: users.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Handle profile photo upload
    $profile_photo = $user['profile_photo'];
    if(isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        $target_dir = "../uploads/profiles/";
        if(!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES["profile_photo"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        if(move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            $profile_photo = 'uploads/profiles/' . $new_filename;
        }
    }
    
    $sql = "UPDATE tbl_user SET 
            name = '$name',
            email = '$email',
            phone_no = '$phone',
            status = '$status',
            profile_photo = '$profile_photo'
            WHERE id = '$id'";
            
    if(mysqli_query($conn, $sql)) {
        $success = "User updated successfully!";
        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_user WHERE id = '$id'"));
    } else {
        $error = "Error updating user!";
    }
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit User</h1>
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
                            <h3 class="card-title">Edit User Details</h3>
                        </div>
                        <div class="card-body">
                            <?php if(isset($success)) { ?>
                                <div class="alert alert-success"><?php echo $success; ?></div>
                            <?php } ?>
                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php } ?>
                            
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $user['name']; ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="phone" value="<?php echo $user['phone_no']; ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1" <?php echo $user['status'] == '1' ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $user['status'] == '0' ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Profile Photo</label>
                                    <?php if($user['profile_photo']) { ?>
                                        <div class="mb-2">
                                            <img src="../<?php echo $user['profile_photo']; ?>" alt="Profile Photo" style="max-width: 200px;">
                                        </div>
                                    <?php } ?>
                                    <input type="file" class="form-control" name="profile_photo">
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Update User</button>
                                <a href="users.php" class="btn btn-default">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once 'script.php'; ?> 