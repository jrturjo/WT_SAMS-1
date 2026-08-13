# Railway Deployment Guide — Step by Step

Complete guide to deploy the Study Abroad Management System (SAMS) to Railway with MySQL.

---

## Prerequisites

- [GitHub account](https://github.com)
- [Railway account](https://railway.app) (sign up with GitHub)
- Git installed on your computer

---

## Step 1: Initialize Git in Your Project

Open a terminal in your project folder:

```bash
cd C:\xampp\htdocs\WT_SAMS
git init
git add .
git commit -m "initial commit"
```

---

## Step 2: Create a GitHub Repository

1. Go to [github.com/new](https://github.com/new)
2. **Repository name:** `WT_SAMS`
3. **Visibility:** Public or Private (your choice)
4. **Do NOT** check "Add a README" (you already have one)
5. Click **Create repository**
6. Copy the repository URL (e.g. `https://github.com/YOUR_USERNAME/WT_SAMS.git`)

---

## Step 3: Push Code to GitHub

```bash
git remote add origin https://github.com/YOUR_USERNAME/WT_SAMS.git
git branch -M main
git push -u origin main
```

> Replace `YOUR_USERNAME` with your actual GitHub username.

---

## Step 4: Create a Railway Project

1. Go to [railway.app](https://railway.app)
2. Click **Login with GitHub**
3. From the dashboard, click **New Project**
4. Select **Deploy from GitHub repo**
5. Authorize Railway to access your GitHub repos if prompted
6. Find and select your `WT_SAMS` repository
7. Railway will start deploying automatically

---

## Step 5: Add MySQL Database

1. Inside your Railway project, click the **+ New** button (top left)
2. Select **Database** → **MySQL**
3. Railway provisions a MySQL instance (takes ~30 seconds)

You now have two services in your project:
- **WT_SAMS** (your PHP app)
- **MySQL** (your database)

---

## Step 6: Link MySQL to Your App

1. Click on your **WT_SAMS** service
2. Go to the **Variables** tab
3. Railway auto-generates MySQL variables. You need to add these manually:

Click **New Variable** and add each one:

| Variable Name | Value |
|---------------|-------|
| `DB_HOST` | `mysql.railway.internal` |
| `DB_USER` | `root` |
| `DB_PASS` | *(see below)* |
| `DB_NAME` | *(see below)* |

**To find DB_PASS and DB_NAME:**
1. Click on your **MySQL** service in the project
2. Go to the **Variables** tab
3. Copy the value of `MYSQL_PASSWORD` → paste as `DB_PASS`
4. Copy the value of `MYSQL_DATABASE` → paste as `DB_NAME`

---

## Step 7: Import Database Tables

1. Click on your **MySQL** service
2. Go to the **Data** tab
3. Click **Query** (or **Console**)
4. Paste the entire contents of `setup.sql`:

```sql
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(100),
    role VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(100),
    phone VARCHAR(20),
    current_university VARCHAR(100),
    address TEXT
);

CREATE TABLE IF NOT EXISTS universities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(100),
    location VARCHAR(100),
    address TEXT,
    ranking INT,
    description TEXT
);

CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    university_id INT,
    course_name VARCHAR(100),
    department VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    university_id INT,
    course_name VARCHAR(100),
    status VARCHAR(20) DEFAULT 'pending',
    feedback TEXT
);

CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    university_id INT,
    message TEXT,
    created_at VARCHAR(20)
);
```

5. Click **Run** to execute the queries

---

## Step 8: Set Custom Domain (Optional)

1. Click on your **WT_SAMS** service
2. Go to **Settings** tab
3. Under **Networking** → **Public Networking**, click **Generate Domain**
4. Railway gives you a URL like: `wt-sams-production.up.railway.app`
5. Click it to open your live app

---

## Step 9: Verify It Works

1. Open your Railway URL
2. You should see the **landing page**
3. Click **Get Started** → try registering a new account
4. Test login, dashboard, profile, etc.

---

## How the Deployment Files Work

```
WT_SAMS/
├── composer.json     ← Tells Railway "this is a PHP project"
├── Procfile          ← Tells Railway how to start the server
├── router.php        ← Handles clean URLs (since Railway uses PHP built-in server, not Apache)
├── config/
│   └── database.php  ← Reads DB credentials from Railway's environment variables
└── .htaccess         ← Still works for local XAMPP (Apache ignores Procfile/router.php)
```

### `composer.json`
```json
{
    "require": {
        "php": ">=8.0"
    }
}
```
Railway detects this file and knows to set up a PHP environment.

### `Procfile`
```
web: php -S 0.0.0.0:$PORT router.php
```
Starts PHP's built-in web server on the port Railway assigns.

### `router.php`
Maps clean URLs (e.g. `/login`) to `index.php?url=login` since there's no Apache `.htaccess` on Railway.

### `config/database.php`
```php
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$name = getenv('DB_NAME') ?: 'sams_db';
```
- **On Railway:** reads from environment variables
- **On XAMPP locally:** falls back to `localhost` / `root` / empty password

---

## Troubleshooting

### 500 Error
- Check that all 4 environment variables (`DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`) are set correctly
- Check that the database tables were imported (Step 7)
- In Railway, go to your app service → **Logs** tab to see the error

### CSS/Images Not Loading
- Make sure `public/css/style.css` path in `header.php` uses a relative path
- Railway serves static files from the project root, so `public/css/style.css` works as-is

### Can't Register/Login
- Open browser DevTools (F12) → **Network** tab
- Try registering and check if the POST request returns 200 or 500
- If 500, check Railway logs for the specific error

### Database Connection Refused
- Make sure `DB_HOST` is `mysql.railway.internal` (not `localhost`)
- Make sure the MySQL service is running (green status in Railway)

---

## Updating After Changes

Every time you push to GitHub, Railway auto-redeploys:

```bash
git add .
git commit -m "description of changes"
git push
```

Railway picks up the push and redeploys in ~30 seconds.

---

## Local Development (Still Works)

Your app still works locally with XAMPP — no changes needed:

1. Start Apache + MySQL in XAMPP
2. Open `http://localhost/WT_SAMS/`
3. Environment variables default to `localhost` / `root` / empty password
