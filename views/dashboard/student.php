<?php include 'views/layouts/header.php'; ?>

<div class="welcome-banner">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <p>Student Dashboard &mdash; Manage your study abroad journey</p>
</div>

<div class="dashboard-grid">
    <a href="index.php?url=profile" class="dashboard-card">
        <div class="card-icon">&#128100;</div>
        <h3>My Profile</h3>
        <p>View and update your personal information</p>
    </a>
    <a href="index.php?url=universities" class="dashboard-card">
        <div class="card-icon">&#127757;</div>
        <h3>Search Universities</h3>
        <p>Browse and apply to partner universities</p>
    </a>
    <a href="index.php?url=history" class="dashboard-card">
        <div class="card-icon">&#128203;</div>
        <h3>My Applications</h3>
        <p>Track the status of your applications</p>
    </a>
</div>

<?php include 'views/layouts/footer.php'; ?>
