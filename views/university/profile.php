<?php include 'views/layouts/header.php'; ?>

<div class="page-header">
    <h1>University Profile</h1>
</div>

<div class="card" style="max-width: 600px;">
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=update_university_profile" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" value="<?php echo htmlspecialchars($data['username']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" value="<?php echo htmlspecialchars($data['email']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="university_name">University Name</label>
            <input type="text" id="university_name" name="university_name" value="<?php echo htmlspecialchars($data['university_name'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($data['location'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($data['description'] ?? ''); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <a href="index.php?url=dashboard" class="back-link">&larr; Back to Dashboard</a>
</div>

<?php include 'views/layouts/footer.php'; ?>
