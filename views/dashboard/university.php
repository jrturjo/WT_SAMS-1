<?php include 'views/layouts/header.php'; ?>

<div class="welcome-banner">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <p>University Dashboard &mdash; Manage courses and applications</p>
</div>

<div class="dashboard-grid">
    <a href="index.php?url=university_profile" class="dashboard-card">
        <div class="card-icon">&#127963;</div>
        <h3>University Profile</h3>
        <p>Update your university information</p>
    </a>
    <a href="index.php?url=manage_courses" class="dashboard-card">
        <div class="card-icon">&#128218;</div>
        <h3>Manage Courses</h3>
        <p>Add or remove course offerings</p>
    </a>
    <a href="index.php?url=view_applications" class="dashboard-card">
        <div class="card-icon">&#128233;</div>
        <h3>View Applications</h3>
        <p>Review and respond to student applications</p>
    </a>
</div>

<?php include 'views/layouts/footer.php'; ?>
