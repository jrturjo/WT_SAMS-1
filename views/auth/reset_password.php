<?php include 'views/layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h2>Reset Password</h2>
        <p class="subtitle">Enter your email and new password</p>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?url=reset_password_submit" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
        </form>

        <div class="auth-links">
            <a href="index.php?url=login">Back to Sign In</a>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
