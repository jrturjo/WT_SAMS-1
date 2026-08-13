<?php include 'views/layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h2>Create Account</h2>
        <p class="subtitle">Join the Study Abroad community</p>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?url=register_submit" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Choose a username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password" required>
            </div>
            <div class="form-group">
                <label for="role">I am a</label>
                <select id="role" name="role">
                    <option value="student">Student</option>
                    <option value="university">University</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </form>

        <div class="auth-links">
            Already have an account? <a href="index.php?url=login">Sign In</a>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
