<?php include 'views/layouts/header.php'; ?>

<div class="page-header">
    <h1>Manage Courses</h1>
</div>

<div class="card" style="max-width: 700px; margin-bottom: 1.5rem;">
    <div class="card-header">
        <h3>Add New Course</h3>
    </div>
    <form action="index.php?url=add_course" method="POST">
        <div class="form-group">
            <label for="department">Department</label>
            <select id="department" name="department">
                <option value="FST">FST</option>
                <option value="FBSS">FBSS</option>
                <option value="FE">FE</option>
                <option value="FLS">FLS</option>
            </select>
        </div>
        <div class="form-group">
            <label for="course_name">Course Name</label>
            <input type="text" id="course_name" name="course_name" placeholder="e.g. Introduction to Computer Science" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Course</button>
    </form>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <h3>Course List</h3>
    </div>

    <?php if (empty($courses)): ?>
        <div class="empty-state">
            <p>No courses added yet.</p>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Course Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($course['department']); ?></td>
                        <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                        <td>
                            <a href="index.php?url=remove_course&id=<?php echo $course['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Remove this course?')">Remove</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<a href="index.php?url=dashboard" class="back-link">&larr; Back to Dashboard</a>

<?php include 'views/layouts/footer.php'; ?>
