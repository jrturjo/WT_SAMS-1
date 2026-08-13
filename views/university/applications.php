<?php include 'views/layouts/header.php'; ?>

<div class="page-header">
    <h1>Received Applications</h1>
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
                    <th>Student Name</th>
                    <th>Course Applied</th>
                    <th>Status</th>
                    <th>Feedback</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $app): ?>
                <tr id="row-<?php echo $app['id']; ?>">
                    <td><?php echo htmlspecialchars($app['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($app['course_name']); ?></td>
                    <td id="status-<?php echo $app['id']; ?>">
                        <span class="badge badge-<?php echo htmlspecialchars($app['status']); ?>"><?php echo htmlspecialchars($app['status']); ?></span>
                    </td>
                    <td>
                        <div class="inline-form">
                            <input type="text" id="feedback-<?php echo $app['id']; ?>" value="<?php echo htmlspecialchars($app['feedback'] ?? ''); ?>" placeholder="Enter feedback">
                            <button class="btn btn-outline btn-sm" onclick="sendFeedback(<?php echo $app['id']; ?>)">Send</button>
                        </div>
                    </td>
                    <td>
                        <?php if ($app['status'] == 'pending'): ?>
                            <div class="inline-form">
                                <button class="btn btn-success btn-sm" onclick="updateStatus(<?php echo $app['id']; ?>, 'accepted')">Accept</button>
                                <button class="btn btn-danger btn-sm" onclick="updateStatus(<?php echo $app['id']; ?>, 'rejected')">Reject</button>
                            </div>
                        <?php else: ?>
                            <span style="color: var(--color-text-muted); font-size: 0.85rem;"><?php echo ucfirst(htmlspecialchars($app['status'])); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<a href="index.php?url=dashboard" class="back-link">&larr; Back to Dashboard</a>

<script>
function updateStatus(id, status) {
    if (!confirm('Are you sure you want to ' + status + ' this application?')) return;

    var formData = new FormData();
    formData.append('id', id);
    formData.append('status', status);

    fetch('index.php?url=update_application_status', {
        method: 'POST',
        body: formData
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
}

function sendFeedback(id) {
    var feedback = document.getElementById('feedback-' + id).value;
    if (!feedback) {
        alert('Please enter feedback');
        return;
    }

    var formData = new FormData();
    formData.append('id', id);
    formData.append('feedback', feedback);

    fetch('index.php?url=update_application_feedback', {
        method: 'POST',
        body: formData
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            alert('Feedback sent successfully');
        } else {
            alert('Error: ' + data.message);
        }
    });
}
</script>

<?php include 'views/layouts/footer.php'; ?>
