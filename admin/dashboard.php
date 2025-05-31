<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MyPharmaRex Blog</title>
    <?php include 'head.php'; ?>   
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <h1 class="mb-4">Manage Blog Posts</h1>
            
            <!-- Add New Post Button -->
            <div class="mb-4 text-end">
                <a href="#" class="btn btn-add-new">Add New Post</a>
            </div>
            
            <!-- Post Management Card -->
            <div class="card">
                <div class="card-header">All Blog Posts</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="blogList">
                                <!-- Blog posts will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Blog Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="statusUpdateForm">
                        <input type="hidden" id="blogId" name="blog_id">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                                <option value="2">Rejected</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateStatusBtn">Update Status</button>
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
        // Load blog posts
        function loadBlogPosts() {
            $.ajax({
                url: '../../function/get_blogs.php',
                method: 'GET',
                success: function(response) {
                    const blogs = JSON.parse(response);
                    let html = '';
                    
                    blogs.forEach(blog => {
                        const statusText = {
                            '0': 'Pending',
                            '1': 'Approved',
                            '2': 'Rejected'
                        }[blog.status] || 'Unknown';
                        
                        html += `
                            <tr>
                                <td>${blog.title}</td>
                                <td>${blog.author_name}</td>
                                <td>${blog.category_name}</td>
                                <td><span class="badge bg-${getStatusColor(blog.status)}">${statusText}</span></td>
                                <td>${new Date(blog.created_at).toLocaleDateString()}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="openStatusModal(${blog.id}, '${blog.status}')">
                                        Update Status
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    
                    $('#blogList').html(html);
                }
            });
        }

        function getStatusColor(status) {
            switch(status) {
                case '0': return 'warning';
                case '1': return 'success';
                case '2': return 'danger';
                default: return 'secondary';
            }
        }

        function openStatusModal(blogId, currentStatus) {
            $('#blogId').val(blogId);
            $('#status').val(currentStatus);
            new bootstrap.Modal(document.getElementById('statusModal')).show();
        }

        // Update status
        $('#updateStatusBtn').click(function() {
            const formData = $('#statusUpdateForm').serialize();
            
            $.ajax({
                url: '../../function/update_blog_status.php',
                method: 'POST',
                data: formData,
                success: function(response) {
                    const result = JSON.parse(response);
                    const toast = new bootstrap.Toast(document.getElementById("toastMessage"));
                    
                    if (result.status === 1) {
                        $('#toastMessage').removeClass('bg-danger').addClass('bg-success');
                    } else {
                        $('#toastMessage').removeClass('bg-success').addClass('bg-danger');
                    }
                    
                    $('#toastBody').text(result.msg);
                    toast.show();
                    
                    if (result.status === 1) {
                        bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
                        loadBlogPosts();
                    }
                }
            });
        });

        // Load posts when page loads
        $(document).ready(function() {
            loadBlogPosts();
        });
    </script>
</body>
</html>
