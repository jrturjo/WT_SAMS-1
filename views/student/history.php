<?php include 'views/layouts/header.php'; ?>

<div class="page-header">
    <h1>Application History</h1>
</div>

<?php if (empty($applications)): ?>
    <div class="card">
        <div class="empty-state">
            <p>No applications found.</p>
        </div>
    </div>
<?php else: ?>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>University</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $app): ?>
                <tr>
                    <td><?php echo htmlspecialchars($app['university_name']); ?></td>
                    <td><?php echo htmlspecialchars($app['course_name']); ?></td>
                    <td><span class="badge badge-<?php echo htmlspecialchars($app['status']); ?>"><?php echo htmlspecialchars($app['status']); ?></span></td>
                    <td><?php echo htmlspecialchars($app['feedback'] ?? ''); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<a href="index.php?url=dashboard" class="back-link">&larr; Back to Dashboard</a>

<?php include 'views/layouts/footer.php'; ?>
