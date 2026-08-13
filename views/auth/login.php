<?php include 'views/layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h2>Welcome Back</h2>
        <p class="subtitle">Sign in to your account</p>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?url=login_submit" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </form>

        <div class="auth-links">
            <a href="index.php?url=reset_password">Forgot Password?</a>
            &middot;
            <a href="index.php?url=register">Create Account</a>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
