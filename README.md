# Blog System

A modern, feature-rich blog system built with PHP that allows users to read, comment, and interact with blog posts across various categories. This project was developed individually as a personal project to demonstrate full-stack development skills.

## Features

- **Blog Management**
  - Create and manage blog posts
  - Rich text content support
  - Image upload and management
  - Category organization
  - Author attribution

- **User Features**
  - User registration and authentication
  - Email verification system
  - Comment system with moderation
  - User profiles
  - Session management

- **Category System**
  - Hierarchical category organization
  - Category-specific pages
  - Category images and descriptions

- **Modern UI/UX**
  - Responsive design
  - Clean and intuitive interface
  - Mobile-friendly layout
  - Modern styling with CSS

## Technical Requirements

- PHP 7.4 or higher
- MySQL/MariaDB
- Web server (Apache/Nginx)
- WAMP/XAMPP/MAMP (for local development)
- PHPMailer (for email functionality)
- Composer (for dependency management)

## Directory Structure

```
blog/
├── admin/
│   ├── ajax/
│   ├── assets/
│   ├── add_post.php
│   ├── category_details.php
│   ├── comments.php
│   ├── dashboard.php
│   ├── edit_post.php
│   ├── edit_user.php
│   ├── footer.php
│   ├── head.php
│   ├── header.php
│   ├── logout.php
│   ├── pending_posts.php
│   ├── post_details.php
│   ├── profile.php
│   ├── script.php
│   ├── sidebar.php
│   ├── users.php
│   └── view_post.php
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── function/
│   ├── BaseManager.php
│   └── ImageManager.php
├── sql/
├── uploads/
├── all_blogs.php
├── all_categories.php
├── blog.php
├── category.php
├── check_database.php
├── database.sql
├── footer.php
├── head.php
├── header.php
├── index.php
├── login.php
├── register.php
├── script.php
└── README.md
```

## Setup Instructions

1. **Database Setup**
   - Create a new MySQL database
   - Import the database schema from `database.sql`
   - Configure database connection in config file

2. **Server Configuration**
   - Place the project in your web server's root directory
   - Ensure proper permissions are set
   - Configure your web server to handle PHP files

3. **Configuration**
   - Update database credentials
   - Configure upload paths for images
   - Set up email settings in `function/email_verification.php`:
     - Configure SMTP settings
     - Set up sender email and password
     - Update email templates if needed

## Usage

1. **Viewing Blogs**
   - Navigate to `all_blogs.php` to see all blog posts
   - Click on individual blog posts to read full content
   - Use category navigation to filter posts

2. **User Interaction**
   - Register/Login to post comments
   - Browse categories
   - View author information

3. **Admin Features**
   - Access admin panel at `/admin/dashboard.php`
   - Manage blog posts
   - Moderate comments
   - Manage categories
   - Handle user accounts
   - View pending posts
   - Edit user profiles

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## Security Features

- SQL injection prevention
- XSS protection
- CSRF protection
- Secure password hashing
- Input validation and sanitization

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, please open an issue in the repository or contact the development team.

## Credits

- Developed individually by [Your Name]
- Built with PHP and MySQL
- Modern UI/UX design
- Personal project showcasing full-stack development capabilities

## About the Developer

This project was built from scratch as an individual project to demonstrate:
- Full-stack development skills
- Database design and management
- User interface design
- Security implementation
- Project architecture and organization

All features, including the admin panel, user management, blog system, and category management were developed independently. 
