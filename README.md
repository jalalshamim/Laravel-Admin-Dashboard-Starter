# Marketiva Laravel Admin Starter

A powerful and feature-rich Laravel 12.x admin panel starter kit with comprehensive user management, role-based access control, activity logging, and a modern UI. Perfect for quickly bootstrapping your next Laravel application with a solid administrative foundation.


## Features
![Admin Edit User Role](https://github.com/user-attachments/assets/96340db6-cfe2-4a4b-bd20-3c11d274e819)


### Core Features
- **User Authentication & Management**
  - Secure login/logout system
  - Password reset functionality
  - User profile management
  - Session management

- **Role-Based Access Control (RBAC)**
  - Comprehensive permission system
  - Role management (Admin, User.)
  - Granular access control


- **Admin Dashboard**
  - Clean and intuitive interface
  - Quick statistics overview
  - Recent activity tracking
  - Responsive design


- **Content Management**
  - Category management with parent-child relationship
  - Post management with featured images
  - Page management
  - SEO optimization fields

- **Menu Builder**
  - Visual drag-and-drop interface
  - Nested menu support
  - Menu permission integration
  - Menu caching system

- **Activity Logging**
  - Detailed user action tracking
  - Activity dashboard
  - Filtering capabilities

### Technical Features
- Built on Laravel 12.x
- PHP 8.2+ compatibility
- MySQL 8.0+ database
- Modern UI with Bootstrap 5.3.3
- jQuery 3.7+ integration
- AJAX-powered operations
- Comprehensive security features

### Future Versions
### Version 1.1.0 [ ]
 Social authentication
 Two-factor authentication
 Advanced media management
 Enhanced SEO tools
 More theme options
 Additional plugins
 
### Version 1.2.0 [ ]
 E-commerce integration
 Advanced analytics
 Multi-language support
 Cache management
 Backup system
 API enhancements
 
### Future Enhancements
Content Management
Enhance the page builder with a drag-and-drop interface
Add a media library for better file management
Add category and tag management
Implement a commenting system
User Management
Add role and permission management
Implement user profile management
Add user activity logging
Implement user authentication with social login

### Analytics
Add dashboard widgets for analytics
Implement Google Analytics integration
Add custom reports for user activity
Add export functionality for reports

### SEO
Add SEO meta fields for pages and posts
Implement XML sitemap generation
Add schema markup support
Add SEO analysis tools

## Installation
1. Clone the repository:
```bash
git clone https://github.com/jalalshamim/laraveladmin.git
cd laraveladmin
```

2. Install PHP dependencies:
```bash
composer install
```

3. Copy environment file and configure your database:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Run database migrations and seed initial data:
```bash
php artisan migrate --seed
```

6. Create storage symlink:
```bash
php artisan storage:link
```

7. Install and compile frontend assets:
```bash
npm install
npm run dev
```

8. Start the development server:
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Features

- User Management
- Role & Permission Management
- Content Management System
- Menu Builder
- Settings Management
- Activity Logging

## License

The Laravel Admin Panel is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
