<?php include 'views/layouts/header.php'; ?>

<div class="page-header">
    <h1>My Profile</h1>
</div>

<div class="card" style="max-width: 600px;">
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=update_profile" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" value="<?php echo htmlspecialchars($data['username']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" value="<?php echo htmlspecialchars($data['email']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($data['name']); ?>">
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($data['phone']); ?>">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($data['address']); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <a href="index.php?url=dashboard" class="back-link">&larr; Back to Dashboard</a>
</div>

<?php include 'views/layouts/footer.php'; ?>
