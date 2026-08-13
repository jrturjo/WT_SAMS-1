<?php include 'views/layouts/header.php'; ?>

<div class="page-header">
    <h1>Browse Universities</h1>
    <p>Find your perfect study abroad destination</p>
</div>

<div id="university-list" class="loading">
    <p>Loading universities...</p>
</div>

<div id="university-details" class="detail-panel" style="display: none;">
    <div style="display: flex; justify-content: space-between; align-items: start;">
        <div>
            <h3 id="detail-name"></h3>
            <div class="detail-meta">
                <span><strong>Location:</strong> <span id="detail-location"></span></span>
            </div>
        </div>
        <button class="btn btn-outline btn-sm" onclick="document.getElementById('university-details').style.display='none'">&times; Close</button>
    </div>
    <p id="detail-description" style="color: var(--color-text-muted); margin-bottom: 1.25rem;"></p>
    <div id="detail-courses"></div>
</div>

<a href="index.php?url=dashboard" class="back-link">&larr; Back to Dashboard</a>

<script>
function loadUniversities() {
    fetch('index.php?url=api_universities')
    .then(function(response) { return response.json(); })
    .then(function(data) {
        var list = document.getElementById('university-list');
        if (data.length > 0) {
            var html = '<div class="dashboard-grid">';
            for (var i = 0; i < data.length; i++) {
                var uni = data[i];
                html += '<div class="dashboard-card" style="cursor: default;">';
                html += '<div class="card-icon">&#127757;</div>';
                html += '<h3>' + uni.name + '</h3>';
                html += '<p>' + uni.location + '</p>';
                html += '<button class="btn btn-primary btn-sm" onclick="viewDetails(' + uni.id + ')">View Details</button>';
                html += '</div>';
            }
            html += '</div>';
            list.innerHTML = html;
        } else {
            list.innerHTML = '<div class="empty-state"><p>No universities found.</p></div>';
        }
    });
}

function viewDetails(id) {
    fetch('index.php?url=api_university_details&id=' + id)
    .then(function(response) { return response.json(); })
    .then(function(data) {
        document.getElementById('detail-name').innerText = data.name;
        document.getElementById('detail-location').innerText = data.location;
        document.getElementById('detail-description').innerText = data.description || '';

        var coursesHtml = '<div class="section-title">Offered Courses</div>';
        if (data.courses && data.courses.length > 0) {
            coursesHtml += '<div class="table-container"><table class="data-table">';
            coursesHtml += '<thead><tr><th>Department</th><th>Course Name</th><th>Action</th></tr></thead><tbody>';
            for (var i = 0; i < data.courses.length; i++) {
                coursesHtml += '<tr>';
                coursesHtml += '<td>' + data.courses[i].department + '</td>';
                coursesHtml += '<td>' + data.courses[i].course_name + '</td>';
                coursesHtml += '<td><button class="btn btn-primary btn-sm" onclick="applyForCourse(' + data.id + ', \'' + data.courses[i].course_name.replace(/'/g, "\\'") + '\')">Apply</button></td>';
                coursesHtml += '</tr>';
            }
            coursesHtml += '</tbody></table></div>';
        } else {
            coursesHtml += '<p style="color: var(--color-text-muted);">No courses available.</p>';
        }

        document.getElementById('detail-courses').innerHTML = coursesHtml;
        document.getElementById('university-details').style.display = 'block';
        document.getElementById('university-details').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
}

function applyForCourse(uniId, courseName) {
    if (!confirm('Apply for ' + courseName + '?')) return;

    var formData = new FormData();
    formData.append('university_id', uniId);
    formData.append('course_name', courseName);

    fetch('index.php?url=apply_course', {
        method: 'POST',
        body: formData
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            alert('Application submitted successfully!');
        } else {
            alert('Error: ' + data.message);
        }
    });
}

loadUniversities();
</script>

<?php include 'views/layouts/footer.php'; ?>
