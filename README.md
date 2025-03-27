# Marketiva Laravel Admin Starter

A powerful and feature-rich Laravel 12.x admin panel starter kit with comprehensive user management, role-based access control, activity logging, and a modern UI. Perfect for quickly bootstrapping your next Laravel application with a solid administrative foundation.

![Inline Preview Image](https://github.com/user-attachments/assets/d8eacc96-7777-4ea7-917e-c0c8c72515e8)


## Features

### Core Features
![Admin Edit User Role](https://github.com/user-attachments/assets/96340db6-cfe2-4a4b-bd20-3c11d274e819)


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
- ![Admin Dashboard](https://github.com/user-attachments/assets/902d2b58-d6be-4365-a4ac-4e6329f8444a)

  - Clean and intuitive interface
  - Quick statistics overview
  - Recent activity tracking
  - Responsive design


- **Content Management**
- ![Admin Posts](https://github.com/user-attachments/assets/b1d03038-a0ef-4bff-bef1-9667e40a8eb0)

  - Category management with parent-child relationship
  - Post management with featured images
  - Page management
  - SEO optimization fields

- **Menu Builder**
- ![Admin Menu Item Builder](https://github.com/user-attachments/assets/c0fd5462-47ac-4952-a562-791a420ed17d)

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

## Requirements

### Development Environment
- PHP 8.2+
- MySQL 8.0+
- Node.js 18+ LTS
- Composer 2.x
- Git 2.x+

### Server Requirements
- PHP 8.2+
- MySQL 8.0+
- Apache/Nginx
- SSL Support
- 40GB storage
- 2GB RAM minimum

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
