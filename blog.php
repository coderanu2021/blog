<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blog Details Page</title>
  <?php include 'head.php'; ?>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }


    /* Footer Styles */
    footer {
      background: #333;
      color: white;
      padding: 20px;
      text-align: center;
      margin-top: 40px;
    }

    footer p {
      margin: 10px 0;
    }

    footer .social-links {
      margin-top: 10px;
    }

    footer .social-links a {
      color: white;
      text-decoration: none;
      margin: 0 10px;
    }

    footer .social-links a:hover {
      color: #ffd700;
    }

    /* Main Content Styles */
    .container {
      display: flex;
      flex-wrap: wrap;
      max-width: 1200px;
      margin: auto;
      padding: 20px;
    }

    .main-content {
      flex: 0 0 70%;
      padding: 20px;
    }

    .sidebar {
      flex: 0 0 30%;
      padding: 20px;
      background: #fff;
      margin-top: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .blog-post {
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }

    .blog-post img {
      max-width: 100%;
      height: auto;
      border-radius: 5px;
      margin-bottom: 15px;
    }

    .author {
      font-size: 0.9em;
      color: #777;
      margin-bottom: 20px;
    }

    .new-comment, .comments-section {
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      margin-bottom: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .comment, .reply {
      margin: 15px 0;
      padding-left: 10px;
      border-left: 2px solid #ccc;
    }

    .reply {
      margin-left: 20px;
    }

    .comment-meta {
      font-weight: bold;
      font-size: 0.9em;
      color: #444;
    }

    .comment-text {
      margin: 5px 0;
    }

    .reply-btn {
      background: none;
      border: none;
      color: #007bff;
      cursor: pointer;
      padding: 0;
      font-size: 0.9em;
    }

    form textarea {
      width: 100%;
      min-height: 60px;
      margin: 10px 0;
      padding: 10px;
      font-size: 1em;
      border: 1px solid #ccc;
      border-radius: 4px;
      resize: vertical;
    }

    form button {
      padding: 8px 16px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    form button:hover {
      background: #0056b3;
    }

    .categories ul {
      list-style: none;
      padding: 0;
    }

    .categories li {
      padding: 8px 0;
      border-bottom: 1px solid #eee;
    }

    .categories a {
      text-decoration: none;
      color: #333;
    }

    .categories a:hover {
      color: #007bff;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .main-content, .sidebar {
        flex: 100%;
      }
    }
  </style>
</head>
<body>

<?php include 'header.php' ?>

  <!-- Main Content Section -->
  <div class="container">
    <!-- Blog Content -->
    <div class="main-content">
      <!-- Blog Post -->
      <article class="blog-post">
        <img src="https://via.placeholder.com/800x400" alt="Blog Image">
        <h1>How to Build a Comment & Reply System</h1>
        <p class="author">By Jane Doe • May 7, 2025</p>
        <div class="blog-body">
          <p>This blog explains how to create a clean comment and reply structure using only HTML, CSS, and JavaScript. You'll learn how to handle nested replies and build a threaded discussion UI.</p>
        </div>
      </article>

      <!-- New Comment -->
      <section class="new-comment">
        <h3>Leave a Comment</h3>
        <form id="comment-form">
          <textarea id="new-comment-text" placeholder="Write a comment..." required></textarea>
          <button type="submit">Post Comment</button>
        </form>
      </section>

      <!-- Comments Section -->
      <section class="comments-section">
        <h3>Comments</h3>
        <div id="comments-container"></div>
      </section>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="categories">
        <h3>Blog Categories</h3>
        <ul>
          <li><a href="#">Web Development</a></li>
          <li><a href="#">JavaScript</a></li>
          <li><a href="#">Frontend Design</a></li>
          <li><a href="#">Database Systems</a></li>
          <li><a href="#">Best Practices</a></li>
        </ul>
      </div>
    </aside>
  </div>
<!-- Footer Section -->
<footer class="bg-dark text-white py-3 mt-5">
    <div class="container text-center">
      <p class="mb-0">&copy; 2025 Your Company. All rights reserved.</p>
    </div>
  </footer>

  <!-- JavaScript for Comments -->
  <script>
    const comments = [
      {
        id: 1,
        user: 'Alice',
        text: 'This is a fantastic guide!',
        replies: [
          { id: 2, user: 'Bob', text: 'Totally agree!' },
          { id: 3, user: 'Charlie', text: 'Thanks for the tips!' }
        ]
      }
    ];

    function renderComments() {
      const container = document.getElementById('comments-container');
      container.innerHTML = '';
      comments.forEach(comment => {
        const commentEl = createCommentElement(comment);
        container.appendChild(commentEl);
      });
    }

    function createCommentElement(comment, isReply = false) {
      const div = document.createElement('div');
      div.className = isReply ? 'reply' : 'comment';

      div.innerHTML = `
        <p class="comment-meta">${comment.user}</p>
        <p class="comment-text">${comment.text}</p>
        <button class="reply-btn" onclick="toggleReplyForm(${comment.id})">Reply</button>
        <form class="reply-form" id="reply-form-${comment.id}" style="display: none;" onsubmit="submitReply(event, ${comment.id})">
          <textarea placeholder="Write a reply..." required></textarea>
          <button type="submit">Post Reply</button>
        </form>
      `;

      if (comment.replies) {
        comment.replies.forEach(reply => {
          const replyEl = createCommentElement(reply, true);
          div.appendChild(replyEl);
        });
      }

      return div;
    }

    function toggleReplyForm(commentId) {
      const form = document.getElementById(`reply-form-${commentId}`);
      form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function submitReply(event, commentId) {
      event.preventDefault();
      const textarea = event.target.querySelector('textarea');
      const replyText = textarea.value.trim();
      if (!replyText) return;

      const comment = comments.find(c => c.id === commentId);
      if (!comment.replies) comment.replies = [];
      comment.replies.push({
        id: Date.now(),
        user: 'You',
        text: replyText,
      });

      textarea.value = '';
      renderComments();
    }

    document.getElementById('comment-form').addEventListener('submit', function(event) {
      event.preventDefault();
      const text = document.getElementById('new-comment-text').value.trim();
      if (!text) return;
      comments.push({
        id: Date.now(),
        user: 'You',
        text: text,
        replies: []
      });
      document.getElementById('new-comment-text').value = '';
      renderComments();
    });

    renderComments();
  </script>

</body>
</html>
