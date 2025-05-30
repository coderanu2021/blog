<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Blog Post</title>
  <?php  include 'head.php'; ?>
 
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

</head>
<body>

<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<div class="content">

  <div class="container">
    <h2>Create a New Blog Post</h2>
    <form id="BLOG_ADD_FORM" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title" class="form-label">Category</label>
        <select class="form-control">
          <option value="">  Select Category </option>


        </select>
      </div>
      <div class="form-group">
        <label for="title" class="form-label">Blog Title</label>
        <input type="text" class="form-control" id="title" placeholder="Enter blog title"  name="title" value="blog title"required>
      </div>

      <div class="form-group">
        <label for="metaTitle" class="form-label">Meta Title</label>
        <input type="text" class="form-control" id="metaTitle" placeholder="Enter meta title" name="metaTitle" value ="blog meta title">
      </div>

      <div class="form-group">
        <label for="metaShortDesc" class="form-label">Meta Short Description</label>
        <textarea class="form-control" id="metaShortDesc" placeholder="Enter short description" name="metaDesc" value="blog short desc"></textarea>
      </div>

      <div class="form-group">
        <label for="longDesc" class="form-label">Long Description</label>
        <textarea class="form-control" id="longDesc" placeholder="Enter detailed description" name="description" value="blog long desc"></textarea>
      </div>

      <div class="form-group">
        <label for="category" class="form-label">Select Category</label>
        <select class="form-select" id="category" name="category_id">
          <option value="1">Technology</option>
          <option value="2">Lifestyle</option>
          <option value="3">Travel</option>
          <option value="4">Education</option>
        </select>
      </div>

      <div class="form-group">
        <label for="coverImage" class="form-label">Upload Cover Image</label>
        <input type="file" class="form-control" id="coverImage"  name="image" accept="image/*">
      </div>

      <button type="submit" class="btn btn-primary">Submit Blog Post</button>
    </form>
  </div>
</div>
 <?php include 'script.php'; ?>

</body>
</html>
