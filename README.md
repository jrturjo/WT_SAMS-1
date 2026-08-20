# SAMS - Study Abroad Management System

A full-stack PHP web application that connects students with universities for study abroad opportunities. Students can browse partner universities, explore courses, and submit applications. Universities can manage their profiles, course offerings, and review applications.

**Live at: https://wtsams.vercel.app**

## Features

### Student
- Browse partner universities with campus photos and details
- View available courses by department
- Apply to courses at preferred universities
- Track application status and feedback in real time

### University
- Manage university profile and course catalog
- Add/remove courses by department (FST, FBSS, FE, FLS)
- Review incoming student applications
- Accept or reject applications with feedback

### General
- Secure authentication with role-based access (Student / University)
- Responsive design with modern UI (cards, badges, tables)
- AJAX-powered interactions for seamless UX
- Password reset flow

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8.5 (vanilla) |
| Database | MySQL via PDO |
| Frontend | HTML5, CSS3, Vanilla JavaScript |
| Server | Apache (XAMPP) / PHP Built-in Server / Vercel serverless |
| Deployment | Vercel (production) + Railway (PHP + MySQL) |

## Project Structure

```
WT_SAMS/
├── index.php                  # Front controller / router
├── router.php                 # Clean URL handler (Railway / PHP built-in server)
├── setup.sql                  # Database schema (7 tables)
├── composer.json              # PHP dependency config (Railway)
├── Procfile                   # Railway deployment config
├── vercel.json                # Vercel routing config
├── .vercelignore              # Files excluded from Vercel builds
├── .htaccess                  # Apache URL rewrite rules
│
├── api/
│   ├── index.php              # Vercel serverless entry point (PHP)
│   └── assets.php             # Serves static files (CSS/images) on Vercel
│
├── config/
│   ├── database.php           # Database connection (PDO, env-aware)
│   └── session_handler.php    # DB-backed session handler (serverless)
│
├── models/                    # Data access layer
│   ├── User.php
│   ├── Student.php
│   ├── University.php
│   ├── Course.php
│   └── Application.php
│
├── controllers/               # Request handlers
│   ├── AuthController.php
│   ├── DashboardController.php
│   ├── StudentController.php
│   ├── UniversityController.php
│   ├── CourseController.php
│   └── ApplicationController.php
│
├── views/                     # PHP templates
│   ├── layouts/
│   │   ├── header.php         # Navbar + HTML head
│   │   └── footer.php         # Footer + closing tags
│   ├── landing.php            # Public landing page
│   ├── auth/                  # Login, register, reset password
│   ├── dashboard/             # Role-based dashboards
│   ├── student/               # Profile, universities, history
│   ├── university/            # Profile, courses, applications
│   └── errors/                # 404, 500 pages
│
├── public/                    # Static assets
│   ├── css/style.css
│   ├── js/
│   └── images/
│
└── photos/                    # Uploaded images
```

## Getting Started

### Prerequisites

- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL + PHP) or PHP 8.0+ with MySQL
- Git

### Local Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/jrturjo/WT_SAMS-1.git
   cd WT_SAMS
   ```

2. **Start Apache and MySQL** via XAMPP Control Panel

3. **Create the database**
   - Open phpMyAdmin (`http://localhost/phpmyadmin`)
   - Import `setup.sql` or run:
     ```sql
     CREATE DATABASE sams_db;
     USE sams_db;
     -- Then import the tables from setup.sql
     ```

4. **Configure database credentials** (if different from defaults)

   Edit `config/database.php` or set environment variables:
   ```
   DB_HOST=localhost
   DB_PORT=3306
   DB_USER=root
   DB_PASS=
   DB_NAME=sams_db
   ```

5. **Access the application**
   ```
   http://localhost/WT_SAMS
   ```

## Database Schema

The system uses 7 tables:

| Table | Description |
|-------|-------------|
| `users` | User accounts (students + universities) |
| `students` | Student profiles |
| `universities` | University profiles |
| `courses` | Course offerings by universities |
| `applications` | Student course applications |
| `feedback` | University feedback on applications |
| `sessions` | DB-backed PHP sessions (required on serverless) |

## Deployment

### Vercel (Production)

1. Push your code to GitHub
2. Import the repo at [vercel.com](https://vercel.com) (framework preset: PHP)
3. Set environment variables:
   ```
   DB_HOST=<public MySQL hostname>
   DB_PORT=<public MySQL port>
   DB_USER=root
   DB_PASS=<MySQL password>
   DB_NAME=<database name>
   ```
4. Deploy. Static assets are served through `api/assets.php` (see `vercel.json`).

> Note: Vercel runs PHP 8.5 serverless. Sessions are stored in the database via `config/session_handler.php` (PHP's file-based sessions do not persist between serverless invocations). The `sessions` table must exist.

### Railway

1. Push your code to GitHub
2. Go to [railway.app](https://railway.app) → **New Project** → **Deploy from GitHub repo**
3. Add a MySQL database: **New** → **Database** → **MySQL**
4. Set environment variables:
   ```
   DB_HOST=mysql.railway.internal
   DB_PORT=3306
   DB_USER=root
   DB_PASS=<auto-generated by Railway>
   DB_NAME=railway
   ```
5. Import `setup.sql` into the Railway MySQL database via the **Data** tab
6. (Optional) Enable **TCP Proxy** under Settings → Networking and use the public hostname for external access

## License

This project is for educational purposes.

## Author

**Jeonta Roy Turjo**