<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Abroad Management System</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="index.php?url=<?php echo isset($_SESSION['user_id']) ? 'dashboard' : ''; ?>" class="navbar-brand">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                Study Abroad
            </a>
            <?php if (isset($_SESSION['user_id'])): ?>
            <ul class="navbar-nav">
                <li><a href="index.php?url=dashboard">Dashboard</a></li>
                <?php if ($_SESSION['role'] === 'student'): ?>
                    <li><a href="index.php?url=profile">Profile</a></li>
                    <li><a href="index.php?url=universities">Universities</a></li>
                    <li><a href="index.php?url=history">Applications</a></li>
                <?php elseif ($_SESSION['role'] === 'university'): ?>
                    <li><a href="index.php?url=university_profile">Profile</a></li>
                    <li><a href="index.php?url=manage_courses">Courses</a></li>
                    <li><a href="index.php?url=view_applications">Applications</a></li>
                <?php endif; ?>
            </ul>
            <div class="navbar-user">
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="index.php?url=logout" class="btn btn-outline btn-sm">Logout</a>
            </div>
            <?php else: ?>
            <div class="navbar-user">
                <a href="index.php?url=login" class="btn btn-outline btn-sm">Sign In</a>
                <a href="index.php?url=register" class="btn btn-primary btn-sm">Get Started</a>
            </div>
            <?php endif; ?>
        </div>
    </nav>
    <main>
