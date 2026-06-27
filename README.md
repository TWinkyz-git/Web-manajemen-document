# Document Management System (DMS)

Sistem Manajemen Dokumen dengan fokus keamanan enterprise-grade.

## Features

✅ Two-Factor Authentication (2FA)
✅ File Encryption (AES-256-GCM)  
✅ Role-Based Access Control (RBAC)
✅ Team Collaboration
✅ Document Management
✅ Audit Logging

## Tech Stack

- Laravel 13
- MySQL
- Blade + TailwindCSS
- Nginx

## Quick Start

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Visit http://localhost:8000

## Default Test Accounts

- **Admin:** admin@example.com / password123
- **Manager:** manager@example.com / password123
- **Staff:** staff@example.com / password123

## Security

- Passwords: bcrypt hashed
- Files: AES-256-GCM encrypted
- 2FA: Email OTP (6 digits)
- RBAC: Role-based permissions
- Audit: Complete action trail